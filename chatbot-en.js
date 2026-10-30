document.addEventListener("DOMContentLoaded", function () {
    const btn = document.createElement("button");
    btn.className = "chatbot-btn";
    btn.innerHTML = "💬";
    document.body.appendChild(btn);

    const box = document.createElement("div");
    box.className = "chatbot-box";
    box.innerHTML = `
        <div class="chatbot-header">SHIFAA MOVE Assistant</div>

        <div class="chatbot-messages" id="chatMessages">
            <div class="bot-msg">Hello 👋 How can I help you?</div>
        </div>

        <div class="quick-questions">
            <button onclick="quickAsk('How do I register?')">Register?</button>
            <button onclick="quickAsk('Where are the exercises?')">Exercises</button>
            <button onclick="quickAsk('How to use favorites?')">Favorites</button>
            <button onclick="quickAsk('Where are the tools?')">Tools</button>
        </div>

        <div class="chatbot-input">
            <input type="text" id="chatInput" placeholder="Type your question here...">
            <button onclick="sendMessage()">Send</button>
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

    if (msg.includes("register") || msg.includes("account") || msg.includes("create") || msg.includes("sign up")) {
        return "You can create an account using the <b>Register</b> button on the home page, and then log in.";
    }

    if (msg.includes("login") || msg.includes("log in") || msg.includes("sign in")) {
        return "Log in using your email and password, and you will be taken directly to your user page.";
    }

    if (msg.includes("exercise") || msg.includes("exercises") || msg.includes("workout")) {
        return "The exercises are on the <b>Exercises</b> page, which includes sections like Post-Operative, Muscle Spasms, and Seniors.";
    }

    if (msg.includes("tool") || msg.includes("tools") || msg.includes("medical") || msg.includes("equipment")) {
        return "Medical tools are on the <b>Tools</b> page. You can add any tool to your favorites by clicking the heart button.";
    }

    if (msg.includes("favorite") || msg.includes("favorites") || msg.includes("heart")) {
        return "To add an exercise or tool to your favorites, click the heart button ❤️, and you will find it on the Favorites page. You can also remove it from there.";
    }

    if (msg.includes("center") || msg.includes("centers") || msg.includes("clinic")) {
        return "The centers are on the <b>Centers</b> page, which contains links and info for physical therapy centers.";
    }

    if (msg.includes("contact") || msg.includes("message") || msg.includes("email")) {
        return "You can contact us from the <b>Contact Us</b> page located in the footer.";
    }

    if (msg.includes("logout") || msg.includes("log out") || msg.includes("sign out")) {
        return "You can log out using the <b>Logout</b> button on your user page.";
    }

    return "I didn't quite catch that 🤔 Try asking about: registration, exercises, tools, favorites, or centers.";
}