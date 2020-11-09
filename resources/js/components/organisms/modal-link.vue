<template>
    <div>
        <v-col cols="12" ref="modalLink" >
            <a @click="openModal()" :src="imagePath" alt="">
                <img :src="imagePath" alt="">
            </a>

            <modal
            :path="imagePath"
            :image-id="imageId"
            :user-id="userId"
            v-show="showContent"
            :create-flag="createFlag"
            :confirm-flag="confirmFlag"
            @close="closeModal"
            @deleteLink="deleteLinkImage"
            >
            </modal>
        </v-col>
        <input v-if="deleteFlag" type="hidden" name="delete_image_ids[]" :value="imageId">
    </div>
</template>

<script>
  export default {
    props: ["file","userId"],
    data(){
        return{
            showContent: false,
            imagePath: '',
            imageId: '',
            createFlag: undefined,
            confirmFlag: undefined,
            deleteFlag: false
        }
    },
    created(){
        var parseFile = JSON.parse(this.$props.file);
        if(parseFile['create_flag'] != undefined){
            this.$data.imagePath = `/storage/app/public/img/tmp/${this.$props.userId}/${parseFile['path']}`;
            this.$data.createFlag = true;
        }else{
            this.$data.imagePath = parseFile['path'];
        }

        if(parseFile['confirm_flag'] != false){
            this.$data.confirmFlag = parseFile['confirm_flag'];
        }

        if(parseFile['id']){
            this.$data.imageId = parseFile['id'];
        }

    },
    methods: {
        openModal(){
            //リンククリックでモーダルオープン
            this.$data.showContent = true;
        },
        //子コンポーネントからのemit
        closeModal(){
            this.$data.showContent = false;
        },
        deleteLinkImage(){
            this.$refs.modalLink.remove();
            this.$data.deleteFlag = true;
        }
    }


  }
</script>
