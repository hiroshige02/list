<template>
    <div>
        <carousel :per-page="perPage" :loop="true">
            <slide v-for="(imagePath, index) in images" :key='index'>
                <div class="slider-inner">
                    <img :ref='`path_${index}`'
                    :src="imagePath" alt=""
                    @click="openModal($event)">
                </div>
            </slide>
        </carousel>

        <!-- 位置的にここならOK openModalでpathに値が与えられる-->
        <modal
        :path="modalSrc"
        v-show="showContent"
        :confirm-flag="true"
        @close="closeModal"
        >
        </modal>


    </div>
</template>

<script>
export default {
    props: ['perPage','images'],
    data(){
        return {
            showContent: false,
            modalSrc: '',
        }
    },
    created(){
    },
    methods: {
        openModal(e){
            //リンククリックでモーダルオープン
            this.$data.modalSrc = e.target.src;
            this.$data.showContent = true;
        },
        //子コンポーネントからのemit
        closeModal(){
            this.$data.showContent = false;
        },

    }
}
</script>

<style scope>

/* .VueCarousel{
  height: 260px;
} */

.VueCarousel-slide{
    /* flex-grow: 0; */
    flex-basis: unset !important;
    /* flex-shrink: 0; */
    /* user-select: none;
    backface-visibility: hidden;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    outline: none; */
}

.VueCarousel-wrapper{
  height: 100% !important;
  width: 370px;
}

.slider-inner {
  width: 170px;
  height: 200px;
  margin-right: 15px;
  /* background-color: #62caaa;
  display: flex; */
  justify-content: center;
  align-items: center;
  /* color: #fff;
  border: 2px solid #fff;
  font-size: 30px; */
  border-radius: 10px;
  overflow:hidden;
  cursor: pointer;
}

img {
    width: 170px;
    height: 200px;
    object-fit: cover;
}
</style>
