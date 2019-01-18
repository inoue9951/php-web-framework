window.onload = function() {
    setMenuBtnEvent();
}

function setMenuBtnEvent() {
    let btns = document.getElementsByClassName('menuBtn');
    for (let i = 0; i < btns.length; i++) {
        btns[i].addEventListener('click', function() {
            //contentArea内の要素を全て非表示にする
            let sections = document.getElementById('contentArea').children;
            for(let j = 0; j < sections.length; j++) {
                sections[j].style.display = "none";
            }
            //クリックしたメニューの要素を表示する
            let targetId = this.id + 'Section';
            document.getElementById(targetId).style.display = "block";
        });
    }
}
