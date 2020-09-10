<template>
    <div>
        <p class="label-text">{{textTitle}}</p>
        <!-- <input-text :text-title="textTitle"></input-text> -->
        <input-text
        :exist-value="existValue"
        >
        </input-text>
    </div>
</template>

<script>
//import MessageContent from "~/resources/atoms/input-text.vue";

    export default {
        props: ['textTitle','existValue']
    }
</script>