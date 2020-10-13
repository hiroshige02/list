<template>
    <div>
        <a @click="openModal()" :src="file" ref="modalLink" alt="Card image">{{file}}</a>
        <modal
        :img-name="file"
        :user-id="userId"
        v-show="showContent"
        @close="closeModal"
        @deleteLink="deleteLinkImage"
        >
        </modal>
    </div>
</template>

<script>
  export default {
    props: ["file","userId"],
    data(){
        return{
            showContent: false
        }
    },
    created(){
        console.log('modal file :' + this.$props.file);
    },
    methods: {
        openModal(file){
            //リンククリックでモーダルオープン
            this.$data.showContent = true;
        },
        //子コンポーネントからのemit
        closeModal(){
            this.$data.showContent = false;
        },
        deleteLinkImage(){
            this.$refs.modalLink.remove();
        }
    }


  }
</script>
