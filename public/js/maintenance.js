//エリアをクリックして都道府県を 表示/非表示
function displayToggle(id){
    //他のエリアがオープンしてたらクローズしなきゃいけないんじゃない？

    let id_string = id + "_prefectures";
    document.getElementById(id_string).classList.toggle('hide');
}
