window.addEventListener('load', function () {

    document.querySelectorAll(".resizer-x").forEach((resizer) => {

        resizer.addEventListener("mousedown", onmousedown);
        resizer.addEventListener("touchstart", ontouchstart);

        // for mobile
        function ontouchstart(e) {
            e.preventDefault();
            resizer.addEventListener("touchmove", ontouchmove);
            resizer.addEventListener("touchend", ontouchend);
        }

        function ontouchmove(e) {
            e.preventDefault();
            const clientX = e.touches[0].clientX;
            const deltaX = clientX - (resizer._clientX || clientX);
            resizer._clientX = clientX;
            const l = resizer.previousElementSibling;
            const r = resizer.nextElementSibling;
            // LEFT
            if (deltaX < 0) {
                const w = Math.round(parseInt(getComputedStyle(l).width) + deltaX);
                l.style.flex = `0 ${w < 10 ? 0 : w}px`;
                r.style.flex = "1 0";
            }
            // RIGHT
            if (deltaX > 0) {
                const w = Math.round(parseInt(getComputedStyle(r).width) - deltaX);
                r.style.flex = `0 ${w < 10 ? 0 : w}px`;
                l.style.flex = "1 0";
            }
        }

        function ontouchend(e) {
            e.preventDefault();
            resizer.removeEventListener("touchmove", ontouchmove);
            resizer.removeEventListener("touchend", ontouchend);
            delete e._clientX;
        }

        // for desktop
        function onmousedown(e) {
            e.preventDefault();
            document.addEventListener("mousemove", onmousemove);
            document.addEventListener("mouseup", onmouseup);
        }

        function onmousemove(e) {
            e.preventDefault();
            const clientX = e.clientX;
            const deltaX = clientX - (resizer._clientX || clientX);
            resizer._clientX = clientX;
            const l = resizer.previousElementSibling;
            const r = resizer.nextElementSibling;
            // LEFT
            if (deltaX < 0) {
                const w = Math.round(parseInt(getComputedStyle(l).width) + deltaX);
                l.style.flex = `0 ${w < 10 ? 0 : w}px`;
                r.style.flex = "1 0";
            }
            // RIGHT
            if (deltaX > 0) {
                const w = Math.round(parseInt(getComputedStyle(r).width) - deltaX);
                r.style.flex = `0 ${w < 10 ? 0 : w}px`;
                l.style.flex = "1 0";
            }
        }

        function onmouseup(e) {
            e.preventDefault();
            document.removeEventListener("mousemove", onmousemove);
            document.removeEventListener("mouseup", onmouseup);
            delete e._clientX;
        }
    });
})
