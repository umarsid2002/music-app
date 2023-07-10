let musicBtn = document.getElementsByClassName('music-btn');
let audioCont = document.getElementById('audio-container')
let audios = []

Array.from(musicBtn).forEach((element, index)=>{
    let btn = document.getElementById(`music-btn${index}`)
    let audio_title = document.getElementById(`music-title${index}`).innerText
    let audio_path = document.getElementById(`song_audio_path${index}`)
    let audio_cover_path = document.getElementById(`song_cover_path${index}`).value
    let audio = new Audio(audio_path.value);
    btn.addEventListener('click', ()=>{
        let button = btn.children[0]
        if(button.classList.contains('fa-circle-play')){
            button.classList.add('fa-circle-pause')
            button.classList.remove('fa-circle-play')
            let playing_id = btn.id
            let play_id = playing_id.substring(9)
            audios.push(audio)
            audio.play()
            // Adding html to audio box - CODE STARTS
            let audioHtml = `<div id='audio-box' class="container-fluid py-3 bg-dark">
            <div class="progress-image w-100 d-flex justify-content-center"><img style="width:120px" src="${audio_cover_path}" alt=""></div>
            <div class="progress-image d-flex justify-content-center text-white">${audio_title}</div>
            <div class="progress d-flex justify-content-center my-3">
                <input class='w-100' type="range" name="audioStatus" id="audioStatus${index}" min='0' value='0'>
            </div>
            <div class="p-container d-flex justify-content-center py-1">
                <div class="previous px-1"><i style="font-size:2.5rem" class="fa-regular text-white fa-square-caret-left"></i></div>
                <div id='aBtn${index}' class="play px-1"><i style="font-size:2.5rem" class="fa-regular text-white fa-circle-pause"></i></div>
                <div class="next px-1"><i style="font-size:2.5rem" class="fa-regular text-white fa-square-caret-right"></i></div>
            </div>
        </div>`
        audioCont.innerHTML = audioHtml
        let audioRange = document.getElementById(`audioStatus${index}`)
        audioRange.setAttribute('max', audio.duration)
        setInterval(() => {
            audioRange.value = audio.currentTime
            console.log(audio.currentTime)
        }, 0.1);
        audioRange.addEventListener("input", (e) => {
            audio.currentTime = audioRange.value;
          });
        let audioBtn = document.getElementById(`aBtn${index}`)
        // when audio container button is clicked
        audioBtn.addEventListener('click', ()=>{
            if (audioBtn.children[0].classList.contains('fa-circle-pause')){
                audioBtn.children[0].classList.add('fa-circle-play')
                audioBtn.children[0].classList.remove('fa-circle-pause')
                button.classList.remove('fa-circle-pause')
                button.classList.add('fa-circle-play')
                audios.shift(audio)
                audio.pause()
                console.log('audio paused')
            }
            else{
                audioBtn.children[0].classList.remove('fa-circle-play')
                audioBtn.children[0].classList.add('fa-circle-pause')
                button.classList.add('fa-circle-pause')
                button.classList.remove('fa-circle-play')
                audios.push(audio)
                audio.play()
                console.log('audio playing')
            }
        })
            // CODE ENDS
                if (audios.length == 2){
                    audios[0].pause()
                    audios.shift()
                }
            // for changing the pause symbol to play when more than one music is played. CODE STARTS
            let song_len = Array.from(musicBtn).length
            for (let songid = 0; songid < song_len; songid++){
                let btns = document.getElementById(`music-btn${songid}`)
                if (songid == play_id){
                    continue
                }
                let play = btns.children[0]
                play.classList.add('fa-circle-play')
                play.classList.remove('fa-circle-pause')
            }
            // CODE ENDS HERE
        }
        else{
            button.classList.remove('fa-circle-pause')
            button.classList.add('fa-circle-play')
            audios.pop()
            audio.pause()
            audioCont.innerHTML = ''
        }
        
    })

})