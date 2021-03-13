<template>
    <div>
        <v-col cols="12" v-if="hasImage" class="no-gutters">
            <v-col cols="4">
                <p>登録済み画像</p>
            </v-col>

            <v-col cols="12" v-for="(f,index) in imageFile" class="no-gutters" :key="index">
                <modal-link
                :file='f'
                :user-id="userId"
                :total-image="totalImages"
                @decreaseInput="decrease"
                @increaseInput="increase"
                >
                </modal-link>
            </v-col>
        </v-col>

        <!-- エラー表示 -->
        <v-col cols="12" v-if="isError" class="no-gutters">
            <v-col cols="12" v-for="(messages,index) in errors" class="no-gutters" :key="index">
                <div v-for="(m,i) in messages" class="no-gutters" :key="i">
                    <p class="error-font">{{ m }}</p>
                </div>
            </v-col>
        </v-col>

        <!-- ローカルストレージにファイルが入っている画像 -->
        <v-col cols="12" v-if="hasTentative" class="no-gutters">
            <v-col cols="4">
                <p>新規登録</p>
            </v-col>

            <v-col cols="12" v-for="(f,index) in tentatives" class="no-gutters" :key="index">
                <modal-link
                :file='f'
                :user-id="userId"
                :total-image="totalImages"
                @decreaseInput="decrease"
                @increaseInput="increase"
                >
                </modal-link>
            </v-col>
        </v-col>

        <v-row no-gutters>
            <file-input-component
            name="file[]"
            font="incre-del-button"
            :total-image="totalImages"
            @decreaseInput="decrease"
            @increaseInput="increase"
            >
            </file-input-component>
        </v-row>

        <v-col cols="12" v-if="maxImage">
            <p class="error-font">画像は５枚が最大です</p>
        </v-col>
    </div>
</template>

<script>
export default {
    props: ["imageFile","errors","userId","tentativeFile","totalImage"],
    data() {
        return {
            totalImages: 0,
            isError: false,
            hasImage: false,
            hasTentative: false,
            images: null,
            tentatives: null,
            maxImage: false
        }
    },
    created() {
        this.$data.totalImages = this.$props.totalImage;
        this.$data.isError = this.$props.errors.length > 0;
        this.$data.hasImage = this.$props.imageFile.length > 0;
        this.$data.hasTentative = this.$props.tentativeFile.length > 0;
        this.$data.images = this.$props.imageFile;
        this.$data.tentatives = this.$props.tentativeFile;
    },
    methods: {
        decrease() {
            this.$data.totalImages--;
            this.$data.maxImage = false;
        },
        increase() {
            if(this.$data.totalImages >= 5) {
                this.$data.maxImage = true;
                return;
            }
            this.$data.totalImages++;
        }
    }
}
</script>


