<template>
    <div>
        <pulldown
        :items="items"
        :label="label"        
        >
        </pulldown>
    </div>
</template>

<script> 
  export default {
    props: ["items","label"]
  }
</script>