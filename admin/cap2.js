let rightCode = '';
//let valiIpt = document.querySelector('#valiIpt');
//let toggleBtn = document.querySelector('#toggle');
//let submitBtn = document.querySelector('#submit');
refresh_img.addEventListener('click', function()
{
  getImgValiCode();
  console.log('click:' + rightCode);
}, false);
/*submitBtn.addEventListener('click', function(){
  if (valiIpt.value === '') {
    alert('verification code must be filled!');
    return false;
  }
  if (valiIpt.value !== rightCode) {
    alert('Verification code error!');
    return false;
  }
  alert('Submitted successfully!')
  valiIpt.value = '';
}, false);*/


getImgValiCode();
console.log('init:' + rightCode);
function getImgValiCode () 
{
  let showNum = [];
  let canvasWinth = 150;
  let canvasHeight = 30;
  let canvas = document.getElementById('valicode');
  let context = canvas.getContext('2d');
  canvas.width = canvasWinth;
  canvas.height = canvasHeight;
  let sCode = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,x,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9,!,@,#,$,%,^,&,*,(,)';
  let saCode = sCode.split(',');
  let saCodeLen = saCode.length;

  for (let i = 0; i <= 6; i++) 
  {
    let sIndex = Math.floor(Math.random()*saCodeLen);
    let sDeg = (Math.random()*30*Math.PI) / 180;
    let cTxt = saCode[sIndex];
    //showNum[i] = cTxt.toLowerCase();
    showNum[i] = cTxt;
    let x = 10 + i*20;
    let y = 20 + Math.random()*8;
    
    //context.font = 'bold 23px 微软雅黑';
    context.font = 'bold 23px Verdana, Arial, Helvetica, sans-serif';

    context.translate(x, y);
    context.rotate(sDeg);

    //context.fillStyle = randomColor();
    context.fillStyle = "#3c6d10";
    context.fillText(cTxt, 0, 0);

    context.rotate(-sDeg);
    context.translate(-x, -y);
  }

  for (let i = 0; i <= 6; i++)
  {
    context.strokeStyle = randomColor();
    context.beginPath();
    context.moveTo(
      Math.random() * canvasWinth,
      Math.random() * canvasHeight
    );
    context.lineTo(
      Math.random() * canvasWinth,
      Math.random() * canvasHeight
    );
    context.stroke();
  }
  
  for (let i = 0; i < 30; i++)
  {
    context.strokeStyle = randomColor();
    context.beginPath();
    let x = Math.random() * canvasWinth;
    let y = Math.random() * canvasHeight;
    context.moveTo(x,y);
    context.lineTo(x+1, y+1);
    context.stroke();
  }
  //rightCode = showNum.join('');

    _("hidden_cap_text").value = showNum.join('');
    _("cap_text").value = '';
    _("cap_text").focus();
}

function randomColor () {
  let r = Math.floor(Math.random()*256);
  let g = Math.floor(Math.random()*256);
  let b = Math.floor(Math.random()*256);
  return 'rgb(' + r + ',' + g + ',' + b + ')';
}