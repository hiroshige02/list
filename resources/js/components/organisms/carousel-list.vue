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