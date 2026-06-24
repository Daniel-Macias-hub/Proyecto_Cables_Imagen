<?php
if (!isset($empty_state_text)) {
    $empty_state_text = "Por el momento no se encuentran elementos<br>disponibles en esta categoría";
}
?>
<style> body { overflow: hidden !important; } </style>
<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 65vh; text-align: center; background: transparent; width: 100%;'>
    <div style='display: flex; align-items: center; justify-content: center; margin-bottom: 30px;'>
        <div style='display: flex; flex-direction: column; gap: 5px; margin-right: 15px;'>
            <div style='width: 38px; height: 38px; background-color: #009fe3; border-radius: 50%;'></div>
            <div style='width: 38px; height: 38px; background-color: #e30613;'></div>
        </div>
        <div style='display: flex; flex-direction: column; align-items: flex-start; justify-content: center;'>
            <div style='font-family: "Arial Black", Impact, sans-serif; font-size: 46px; font-weight: 900; color: var(--bs-body-color, #ffffff); line-height: 0.85; letter-spacing: -0.5px;'>IMAGEN</div>
            <div style='font-family: "Outfit", Arial, sans-serif; font-size: 23px; font-weight: 500; color: var(--bs-body-color, #ffffff); line-height: 1; letter-spacing: 1.5px; margin-top: 2px;'>TELEVISIÓN</div>
        </div>
    </div>

    <h5 style='color: var(--bs-secondary-color, #aaaaaa); font-family: "Outfit", sans-serif; font-weight: 600; margin-bottom: 20px; font-size: 1.5rem; line-height: 1.4;'><?= $empty_state_text ?></h5>
    
    <svg id='emptySvg' viewBox='0 250 800 100' xmlns='http://www.w3.org/2000/svg' style='width: 100%; max-width: 400px; height: 60px; margin: 0 auto; display: block; visibility: hidden;'>
        <g class='dots'>
            <circle class='mainDot' cx='300' cy='300' r='12.5' fill='#E30613'/>
            <g class='otherDots' fill='#009FE3'>
                <circle cx='340' cy='300' r='12.5' />
                <circle cx='380' cy='300' r='12.5' />
                <circle cx='420' cy='300' r='12.5' />
                <circle cx='460' cy='300' r='12.5' />
                <circle cx='500' cy='300' r='12.5' />
            </g>
        </g>
    </svg>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js'></script>
<script>
    if (typeof gsap !== 'undefined') {
        gsap.set('#emptySvg', { visibility: 'visible' });
        var tl = gsap.timeline({repeat: -1}).timeScale(1.42);
        tl.to('.mainDot', { duration: 1, x: 240, ease: 'sine.inOut' })
          .to('.otherDots circle', { duration: 0.3, y: -40, ease: 'sine.out', stagger: {each: 0.09, from: 'start'} }, 0.06)
          .to('.otherDots circle', { duration: 0.7, y: 0, ease: 'bounce.out', stagger: {each: 0.09, from: 'start'} }, 0.48)
          .to('.otherDots circle', { duration: 0.7, scaleY: 0.75, scaleX: 1.2, transformOrigin: 'bottom', ease: 'power1.inOut', stagger: {each: 0.09, from: 'start'} }, 0.48)
          .to('.otherDots circle', { duration: 1, x: -40, ease: 'expo.out', stagger: {each: 0.09, from: 'start'} }, 0.68)
          .to('.mainDot', { duration: 1.8, x: 200, ease: 'elastic.out(1, 0.4)' }, 1);
    }
</script>
