(function() {
    var quarters = 0;
    var scrollHeight, quarterHeight, scrollDistance, divisible, scrollPercent;
    document.addEventListener("scroll", function() {
        scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        quarterHeight = scrollHeight / 4;
        scrollDistance = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;
        divisible = Math.trunc(scrollDistance / quarterHeight);
        if (quarters < divisible && divisible !== Infinity) {
            scrollPercent = divisible * 25;
            heap.track('Scroll Depth', {
                percent: scrollPercent
            });
            quarters++;
        }
    });
}());