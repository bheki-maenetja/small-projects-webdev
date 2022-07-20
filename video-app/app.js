function main() {
    // DOM Variables
    const video = document.querySelector("#my-video");
    let canvas = document.querySelector('#my-canvas');
    clickBtn = document.querySelector('#photo-taker');
    saveBtn = document.querySelector('#save-btn');
    
    setVideo(video) // set video parameters

    // Functions
    function renderSnapshot(w, h) {
        let ctx = canvas.getContext('2d');

        // ctx.drawImage( video, 0, 0, canvas.width, canvas.height );
        ctx.drawImage( video, 0, 0, w, h );
        let image = canvas.toDataURL('image/jpeg');
    }

    // Event Listeners
    clickBtn.addEventListener('click', () => {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        // canvas.width = video.offsetWidth;
        // canvas.height = video.offsetHeight;
        // console.log(video.offsetWidth);
        canvas.getContext('2d').clearRect(0,0, canvas.width, canvas.height)
        renderSnapshot(canvas.width, canvas.height)
    });

    window.addEventListener('resize', () => {
        // renderSnapshot(canvas.width, canvas.height)
    })

    saveBtn.addEventListener('click', () => {
        let canvasUrl = canvas.toDataURL('image/jpeg');

        const createEl = document.createElement('a');
        createEl.href = canvasUrl;

        createEl.download = "saved-snapshot";

        createEl.click();
        createEl.remove();
    })
}

function setVideo(video) {
    video.setAttribute("playsinline", "");
    video.setAttribute("autoplay", "");
    video.setAttribute("muted", "");

    const facingMode = "user";
    const constraints = {
        audio: false,
        video: {
            facingMode,
            width: {ideal: 360},
            height: {ideal: 640}
        }
    };

    navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
        video.srcObject = stream;
    });
}

window.addEventListener('DOMContentLoaded', main)