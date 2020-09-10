<template>
    <div>
        <p class="label-text">{{name}}</p>
        <text-area 
            :name="name"
            :value="value"
            :placeholder="placeholder"
            :color="color"
        >
        </text-area>
    </div>
</template>


<script> 
  export default {
    props: ['name','value','placeholder','color'],
    data() {
        return {

        }
    },
  }
</script>