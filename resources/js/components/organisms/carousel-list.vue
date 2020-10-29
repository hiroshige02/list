<template>
    <div>
        <!-- <carousel autoplay="true" loop="true"> -->
        <carousel :per-page="perPage" :loop="true">
            <slide v-for="(n,index) in 5" :key='index'>
                <div class="slider-inner">
                    Slide {{n}} Content
                    <!-- ここにimgタグを設置 -->
                </div>
            </slide>
        </carousel>
    </div>
</template>

<script>
export default {
    props: ['perPage'],
}
</script>

<style>

.VueCarousel{
  height: 300px;
}
.VueCarousel-wrapper, .VueCarousel-inner, .VueCarousel-slide{
  height: 100% !important;
}
.VueCarousel-slide .slider-inner {
  height: 100%;
  background-color: #62caaa;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  border: 2px solid #fff;
  font-size: 30px;
  border-radius: 10px;
}
</style>
