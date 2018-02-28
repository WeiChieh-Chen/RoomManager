$(function(){
    let panel = document.getElementsByClassName('main-panel')[0];
    let top = panel.clientHeight / 2;

    let element = document.getElementsByClassName('scrollFix')[0];
    let fixTop = top - element.clientHeight * 2;

    element.style.top = fixTop + 'px';
    panel.addEventListener('scroll',function(){
        let scrollVar = this.scrollTop;
        element.style.top =  fixTop + scrollVar +'px';
    });
});

