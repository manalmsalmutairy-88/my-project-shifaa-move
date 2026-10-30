document.addEventListener("DOMContentLoaded", function () {
    const btn = document.createElement("button");
    btn.className = "chatbot-btn";
    btn.innerHTML = "💬";
    document.body.appendChild(btn);

    const box = document.createElement("div");
    box.className = "chatbot-box";
    box.innerHTML = `
        <div class="chatbot-header">مساعد SHIFAA MOVE</div>

        <div class="chatbot-messages" id="chatMessages">
            <div class="bot-msg">أهلًا 👋 كيف أقدر أساعدك؟</div>
        </div>

        <div class="quick-questions">
            <button onclick="quickAsk('كيف أسجل؟')">كيف أسجل؟</button>
            <button onclick="quickAsk('وين التمارين؟')">التمارين</button>
            <button onclick="quickAsk('كيف أضيف للمفضلة؟')">المفضلة</button>
            <button onclick="quickAsk('وين الأدوات؟')">الأدوات</button>
        </div>

        <div class="chatbot-input">
            <input type="text" id="chatInput" placeholder="اكتب سؤالك هنا...">
            <button onclick="sendMessage()">إرسال</button>
        </div>
    `;
    document.body.appendChild(box);

    btn.onclick = function () {
        box.style.display = box.style.display === "flex" ? "none" : "flex";
    };

    const input = document.getElementById("chatInput");
    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });
});

function sendMessage() {
    const input = document.getElementById("chatInput");
    const msg = input.value.trim();

    if (msg === "") return;

    addMessage(msg, "user-msg");
    input.value = "";

    setTimeout(() => {
        addMessage(getBotReply(msg), "bot-msg");
    }, 400);
}

function quickAsk(text) {
    document.getElementById("chatInput").value = text;
    sendMessage();
}

function addMessage(text, className) {
    const messages = document.getElementById("chatMessages");
    const div = document.createElement("div");
    div.className = className;
    div.innerHTML = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function getBotReply(msg) {
    msg = msg.toLowerCase();

    if (msg.includes("سجل") || msg.includes("حساب") || msg.includes("انشاء")) {
        return "تقدرين تنشئين حساب من زر <b>إنشاء حساب</b> في الصفحة الرئيسية، وبعدها تسجلين دخول.";
    }

    if (msg.includes("دخول") || msg.includes("login")) {
        return "سجلي دخول باستخدام بريدك وكلمة المرور، وبعدها تنتقلين مباشرة لصفحة المستخدم.";
    }

    if (msg.includes("تمارين") || msg.includes("تمرين")) {
        return "التمارين موجودة في صفحة <b>التمارين</b>، وفيها أقسام مثل ما بعد العمليات، الشدود العضلية، وكبار السن.";
    }

    if (msg.includes("أدوات") || msg.includes("ادوات") || msg.includes("طبية")) {
        return "الأدوات الطبية موجودة في صفحة <b>الأدوات</b>، وتقدرين تضيفين أي أداة للمفضلة من زر القلب.";
    }

    if (msg.includes("مفضلة") || msg.includes("قلب")) {
        return "لإضافة تمرين أو أداة للمفضلة اضغطي زر القلب ❤️، وبتلقينها في صفحة المفضلة. وتقدرين تحذفينها من هناك.";
    }

    if (msg.includes("مراكز") || msg.includes("مركز")) {
        return "المراكز موجودة في صفحة <b>المراكز</b>، وفيها روابط ومعلومات مراكز العلاج الطبيعي.";
    }

    if (msg.includes("تواصل") || msg.includes("رسالة")) {
        return "تقدرين تتواصلين معنا من صفحة <b>تواصل معنا</b> الموجودة في الفوتر.";
    }

    if (msg.includes("خروج")) {
        return "تقدرين تسجيل الخروج من زر <b>تسجيل الخروج</b> في صفحة المستخدم.";
    }

    return "ما فهمت سؤالك بالضبط 🤔 جربي تسألين عن: التسجيل، التمارين، الأدوات، المفضلة، أو المراكز.";
}