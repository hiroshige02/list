<template>
    <custom-button
    :type="type"
    :event-name="eventName"
    :button-color="buttonColor"
    :button-text="buttonText"
    :is-small="isSmall"
    :is-normal="isNormal"
    :is-large="isLarge"
    :height="height"
    :width="width"
    :min-width="minWidth"
    :min-height="minHeight"
    :font="font"
    >
    </custom-button>
</template>

<script>
  export default {
    props: ['type','buttonText','buttonColor',
    'isSmall','isNormal','isLarge',
    'height','width','minWidth','minHeight',
    'font','eventName'],
    data() {
        return {};
    },
    }
</script>
