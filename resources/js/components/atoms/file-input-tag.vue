<template>
    <div>

        <v-file-input
        v-model="files"
        color="pink accent-4"
        counter
        label=""
        multiple
        placeholder="ファイルを選択してください"
        prepend-icon="mdi-paperclip"
        outlined
        :show-size="1000"
        :name="name"
        :error-messages="errorMessages"
        accept="image/*"
        >
            <template v-slot:selection="{ index, text }">
                <v-chip
                v-if="index < 2"
                color="pink accent-4"
                dark
                label
                normal
                >
                {{ text }}
                </v-chip>

                <span
                v-else-if="index === 2"
                class="overline grey--text text--darken-3 mx-2"
                >
                +{{ files.length - 2 }} File(s)
                </span>
            </template>
        </v-file-input>

    </div>
</template>

<script> 
  export default {
    props: ["name","errorMessages","files"]
  }
</script>