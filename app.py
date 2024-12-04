from flask import Flask, request, jsonify
from openai import OpenAI
from opencc import OpenCC
import os
from flask_cors import CORS

OpenAI.api_key = os.getenv("OPENAI_API_KEY")

app = Flask(__name__)
CORS(app)

# 繁體轉換工具
cc = OpenCC('s2t')  # 簡體轉繁體

# 條件
system_message = (
    "你是心理治療師，你需要透過多方面的問題來瞭解問問題的人，不能只是單方面的回答，要真正了解這些遇到狀況的人出了什麼事，並且一步步去跟他溝通，給予他合適的建議。"
    "所有回應必須是繁體中文，任何出現簡體字的內容都不符合要求，請避免使用簡體字。回應需要像跟人聊天一樣自然，不要過於生硬或冗長。"
)

# 初始化 OpenAI 客戶端
client = OpenAI()

# 歷史訊息
conversation_history = []

def ask_mazu_ai(question):
    try:
        # 新增用戶訊息到歷史記錄
        conversation_history.append({"role": "user", "content": question})

        # 發送至 OpenAI 取得回應
        completion = client.chat.completions.create(
            model="gpt-4-turbo",
            messages=[{"role": "system", "content": system_message}] + conversation_history,
            max_tokens=500,
            temperature=0.8
        )

        # 獲取 OpenAI 的回應
        response = completion.choices[0].message.content.strip()
        
        # 強制將回應轉換為繁體中文
        response = cc.convert(response)
        
        # 新增助手回應到歷史記錄
        conversation_history.append({"role": "assistant", "content": response})

        return response

    except Exception as e:
        print("發生錯誤:", e)
        return str(e)

@app.route("/ask", methods=["POST"])
def ask():
    data = request.get_json()
    user_question = data.get("question", "")
    
    if not user_question:
        return jsonify({"error": "未提供問題"}), 400
    
    try:
        response = ask_mazu_ai(user_question)
        return jsonify({"response": response})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5000, debug=True)