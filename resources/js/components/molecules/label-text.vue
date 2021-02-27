<template>
    <div>
        <p>{{textTitle}}</p>
        <input-text
        :type="type"
        :value="value"
        :name="name"
        :error-messages="errorMessages"
        :color="color"
        >
        </input-text>
    </div>
</template>

<script>

    export default {
        props: ['textTitle','type','value','name','errorMessages','color']
    }
</script>
