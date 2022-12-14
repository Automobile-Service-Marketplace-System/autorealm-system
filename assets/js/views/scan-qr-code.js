import {Html5QrcodeScanner} from 'html5-qrcode'; 

const qrcodeScanner=new Html5QrcodeScanner("reader" /*ID from .html file*/,{
    fps: 10,
    aspectRatio: 1.0,
    showZoomSliderIfSupported:true,
});

qrcodeScanner.render((arg1,arg2)=>{
    let qrcode_result = document.querySelector(".qrcode-result");
    qrcode_result.style.display = "block";
    console.log(arg1,arg2)
}, (errMsg,err)=>{
    console.log(errMsg,err)
})
