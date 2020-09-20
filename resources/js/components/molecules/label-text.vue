<template>
    <div>
        <p class="label-text">{{textTitle}}</p>
        <!-- <input-text :text-title="textTitle"></input-text> -->
        <input-text
        :value="value"
        :name="name"
        :error-messages="errorMessages"
        >
        </input-text>
    </div>
</template>

<script>

    export default {
        props: ['textTitle','value','name','errorMessages']
    }
</script>
