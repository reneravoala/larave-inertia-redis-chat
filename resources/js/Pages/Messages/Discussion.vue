<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import moment from "moment/dist/moment";

const props = defineProps({
    thread: Object,
    messages: Object,
    other: Object,
    user: Object,
});

let messages = ref(props.messages);

const redis = io('http://localhost:3000/', { transports : ['websocket'] });

let messagesContainer;
onMounted(() => {
    messagesContainer = document.getElementById('messages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});

redis.on('laravel_database_messages_' + props.thread.id, (data) => {
    console.log(data);
    messages.value.push(data);
    console.log(messagesContainer.scrollHeight)
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});

const form = useForm({
    _method: 'POST',
    body: '',
});

const createMessage = () => {
    form.post(route('messages.create', props.thread), {
        errorBag: 'createMessage',
        preserveScroll: true,
        onSuccess: () => form.reset('body'),
    })
}

// const setRead = () => {
//     axios.put(route('messages.set-read'), {
//         thread_id: props.thread.id
//     });
// }

</script>

<template>

    <div class="py-12 h-[70vh] overflow-y-auto" id="messages">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg flex flex-col p-5">
                <ul>
                    <li v-for="message in messages" key="thread.id" :class="[ message.user_id === user.id ? 'text-right' : 'text-left' ]" class="my-2 border border-black/10 p-2">
                        <span class="text-sm font-bold mr-2">{{ message.name }}</span>
                        {{ message.body }}
                        <span class="text-xs">{{ moment(message.created_at).fromNow() }}</span></li>
                </ul>
                <form @submit.prevent="createMessage" class="ml-auto">
                    <textarea v-model="form.body" rows="5" cols="30" @keydown.ctrl.enter="createMessage"></textarea>
                    <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Envoyer</PrimaryButton>
                </form>

            </div>
        </div>
    </div>
</template>
