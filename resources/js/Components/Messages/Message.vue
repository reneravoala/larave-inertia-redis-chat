<script setup>
defineProps({
    message: Object,
})
</script>

<template>
    <div class="text-lg 2xl:text-2xl font-medium flex xl:mr-20 2xl:mr-40">
        <div class="min-w-fit">
            <img :src="message.icon" alt="Personne" class="rounded-full h-12 2xl:h-20 w-12 2xl:w-20 object-cover">
        </div>
        <div class="w-fit ml-6">
            <div class="text-blue-150">
                {{ message.nom }}
                <span class="border-l-2 pl-3  ml-10 text-[13px] text-gray-350 font-thin italic">{{ message.date }}</span>
            </div>
            <div class="text-base 2xl:text-[21px] 2xl:leading-7 text-gray-350 font-thin italic" v-html="message.text"></div>
        </div>
    </div>
</template>
