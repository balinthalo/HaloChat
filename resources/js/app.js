import axios from 'axios';
import './bootstrap';

if (document.getElementById('messages')) {
    function scrollToBottom() {
        const msgElement = document.getElementById('messages')
        msgElement.scrollTo(0, msgElement.scrollHeight)
    }

    async function updateChat () {
        const chat_id = document.getElementById('chat_id').getAttribute('chat_id')
        await axios.get(`/chat/${chat_id}/download`).then((response) => {
            const messages = response.data.messages
            const users = response.data.users
            drawMessages(messages, users)
        })
    }

    async function updateChatWithScrollToBottom () {
        await updateChat() // első letöltés (AZONNAL)
        scrollToBottom() // első letöltés után görgessünk alulra
    }

    updateChatWithScrollToBottom()

    const updateChatInterval = setInterval(updateChat, 5*1000) // frissítés (5 mp-ként)
    // leállításhoz a változó kellene: clearInterval(updateChatInterval)

    function drawMessages (messages, users) {
        // Jelenlegi user
        const auth_user_id = document.getElementById('auth_user_id').getAttribute('auth_user_id')

        // Teljes messages tartalma lesz
        let html = ``

        // Más üzenete
        const htmlOther = `
            <div class="w-full flex justify-start">
                <div class="flex flex-col max-w-2/3">
                    <div>##username##</div>
                    <div class="px-4 py-1 rounded-lg rounded-tl-none bg-slate-500 text-slate-50 break-word">##text##</div>
                    <div class="text-xs text-slate-400">##date##</div>
                </div>
            </div>`
        // Saját üzenetünk
        const htmlSelf = `
            <div class="w-full flex justify-end text-right">
                <div class="flex flex-col max-w-2/3">
                    <div>##username##</div>
                    <div class="px-4 py-1 rounded-lg rounded-tr-none bg-slate-500 text-slate-50 break-word">##text##</div>
                    <div class="text-xs text-slate-400">##date##</div>
                </div>
            </div>`;

        messages.forEach(message => {
            const user = users.find((us) => String(us.id) === String(message.sender_id))
            const userName = user?.name ?? 'ismeretlen'

            const isAuthUser = auth_user_id === String(user?.id ?? null)
            const template = isAuthUser ? htmlSelf : htmlOther
            html += template
                .replace('##username##', userName)
                .replace('##text##', message.text)
                .replace('##date##', new Date(message.created_at).toLocaleDateString())
        })

        const msgElement = document.getElementById('messages')
        msgElement.innerHTML = html
    }

    function sendMessage () {
        const chat_id = document.getElementById('chat_id').getAttribute('chat_id')
        const textInputElement = document.querySelector('input[name="text"]')
        const text = textInputElement.value

        // ürítsük ki az input mezőt, hogy ne tudjuk duplán elküldeni
        textInputElement.value = ''

        axios.post(`/chat/${chat_id}/message/store`, {
            text: text
        }, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(async () => {
            // a végén kell frissíteni rögtön a chat-et, hogy a user ne érezzen "késleltetést"
            await updateChat()
            // ezt követően görgessünk az utolsó üzenetünkhöz
            scrollToBottom()
        })
    }

    document.querySelector('input[type="submit"]').addEventListener('click', sendMessage)
}
