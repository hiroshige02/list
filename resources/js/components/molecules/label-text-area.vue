<template>
    <div>
        <p class="label-text">{{label}}</p>
        <text-area
        :name="name"
        :value="value"
        :placeholder="placeholder"
        :color="color"
        :error-messages="errorMessages"
        >
        </text-area>
    </div>
</template>


<script>
  export default {
    props: ['label','name','value','placeholder','color','errorMessages'],
    data() {
        return {

        }
    },
  }
</script>
