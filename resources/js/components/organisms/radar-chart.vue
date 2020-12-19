<script>
    import { Radar } from 'vue-chartjs';

    export default {
    extends: Radar,
    props: ["raderData", "sakeName"],
    name: 'chart',
    data () {
        return {
            data: {
                labels: ['甘さ', '酸味', '味の濃さ', 'コストパフォーマンス', '淡麗さ','おすすめ度', '辛さ'],
                datasets: [
                    {
                        label: this.$props.sakeName,
                        data: [],
                        backgroundColor: "rgba(228,101,150,0.2)",
                        borderColor: "rgba(228,101,150,0.2)",
                        borderWidth: 2,
                        spanGaps: true,
                        fontSize: 16,
                    },
                ]
            },
            options: {
                responsive: true,
                title: {  // タイトル
                    display: true,
                    fontSize: 20,
                    text: "個人評価グラフ"
                },
                legend: {
                    position: 'bottom', // 凡例の表示位置
                    display: false
                },
                scale: {
                    pointLabels: {
                        fontSize: 13,
                    },
                    ticks: {
                        suggestedMax: 5,
                        suggestedMin: 0,
                        stepSize: 1,
                    },
                    gridLines: {// 補助線（目盛の線）
                        display: true,
                        color: "mistyrose"
                    }
                }
            }
        }
    },
    created() {
        this.$data.data.datasets[0].data = this.$props.raderData;
    },
    mounted () {
        this.renderChart(this.data, this.options);
    }
}
</script>
