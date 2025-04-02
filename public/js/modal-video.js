let videoFrame = document.getElementById('videoFrame');
const targetEl = document.getElementById('video-modal');
const pathVideo = document.getElementById('path_video').value;

const options = {
    placement: 'bottom-right',
    backdrop: 'dynamic',
    backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
    closable: true,
    onHide: () => {
        videoFrame.removeAttribute('src');
    },
    onShow: () => {
        if (pathVideo) {
            videoFrame.src = 'https://www.youtube.com/embed/' + pathVideo;
            // console.log('Video Frame Updated: ', videoFrame.src);
        } else {
            console.error('Path video tidak ditemukan!');
        }
    },
};

const modal = new Modal(targetEl, options);