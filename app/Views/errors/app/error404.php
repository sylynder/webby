<?php defined('COREPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title><?= 'Custom Error Page' . ' | ' . config_item('app_name') ?></title>
	<script src="<?= APP_BASE_URL . 'assets/tailwind.css?plugins=typography' ?>"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						webby: "#6d00cc",
					}
				}
			}
		}
	</script>
	<style type="text/tailwindcss">
		@layer components {

            .bg-primary {
                @apply bg-gradient-to-br
                from-purple-100 
                to-pink-100 
                via-cyan-100;
            }

			.w-svg {
				/* @apply */
			}
        }

		@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,800&display=swap');

		body {
			font-family: montserrat,sans-serif;
			color: #6d00cc;
			text-align: center;
			margin: 0 !important;
			padding: 0;
			list-style: none;
			border: 0;
			-webkit-tap-highlight-color: transparent;
		}

		svg {
			top: 2em !important;
			width: 40vw;
			text-align: center;
			max-width: 1280px;
			overflow: visible;
		}

		.w-oops-content{
			background-color: rgb(0,0,0,0);
		}

		.w-oops {
			margin: 0;
			font-size: 5vw;
			font-weight: 800 !important;
			margin-top: -0.8em;
		}

		.w-who {
			font-size: 2vw;
			margin: 0 !important;
		}

		.w-wrong {
			font-size: 1.2vw;
		}

		.w-button {
			font-family: 'Montserrat', 'Arial', sans-serif;
			display: inline-block;
			font-size: 1.2em;
			font-weight: 600;
			padding: 1em 2em;
			margin-top: 1em;
			margin-bottom: 60px;
			-webkit-appearance: none;
			appearance: none;
			background-color: #48049c;
			color: #e3f6fa;
			border-radius: 4px;
			border: none;
			cursor: pointer;
			position: relative;
			transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
			box-shadow: 0 2px 25px rgba(204, 200, 180, 0.5);
		}

		.w-button:hover {
			background-color: #5b08c2;
			color: white;
		}
		
		.w-button:focus {
			outline: 0;
		}
		
		.w-button:before, .w-button:after{
			position: absolute;
			content: '';
			display: block;
			width: 140%;
			height: 100%;
			left: -20%;
			z-index: -1000;
		}
    </style>
</head>

<body class="w-full bg-primary">
	<div class="">
		<div class="w-svg hero container max-w-screen-lg mx-auto pb-10 flex justify-center">
			<svg id="evQrI1MWBnR1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-110 0 1200 680" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" style="background-color:rgb(255,255,255, 0)">
				<defs>
					<radialGradient id="evQrI1MWBnR3-fill" cx="0" cy="0" r="432.23" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 0.48 436.37 1.074)">
						<stop id="evQrI1MWBnR3-fill-0" offset="0%" stop-color="rgb(240,229,160)" />
						<stop id="evQrI1MWBnR3-fill-1" offset="45%" stop-color="rgb(227,227,227)" />
						<stop id="evQrI1MWBnR3-fill-2" offset="100%" stop-color="rgb(255,255,255)" />
					</radialGradient>
					<linearGradient id="evQrI1MWBnR4-fill" x1="462.18" y1="142.04" x2="462.18" y2="386.02" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR4-fill-0" offset="0%" stop-color="rgb(255,240,143)" />
						<stop id="evQrI1MWBnR4-fill-1" offset="100%" stop-color="rgb(255,228,54)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR5-stroke" x1="850.03" y1="320.62" x2="850.03" y2="39.32" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR5-stroke-0" offset="0%" stop-color="rgb(255,98,106)" />
						<stop id="evQrI1MWBnR5-stroke-1" offset="100%" stop-color="rgb(255,159,164)" />
					</linearGradient>
					<radialGradient id="evQrI1MWBnR6-fill" cx="0" cy="0" r="53.912807" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.01685 0.999858 -0.423578 0.007138 756.319076 634.006711)">
						<stop id="evQrI1MWBnR6-fill-0" offset="0%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR6-fill-1" offset="100%" stop-color="rgb(72, 4, 156)" />
					</radialGradient>
					<linearGradient id="evQrI1MWBnR8-fill" x1="487.63" y1="682.4" x2="487.63" y2="499.28" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR8-fill-0" offset="0%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR8-fill-1" offset="50%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR8-fill-2" offset="100%" stop-color="rgb(72, 4, 156)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR9-fill" x1="752.381012" y1="703.75675" x2="747.672722" y2="572.589931" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR9-fill-0" offset="0%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR9-fill-1" offset="38%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR9-fill-2" offset="61%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR9-fill-3" offset="95.6816%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR9-fill-4" offset="100%" stop-color="rgba(72, 4, 156, 0)" />
					</linearGradient>
					<filter id="evQrI1MWBnR10-filter" x="-400%" width="600%" y="-400%" height="600%">
						<feGaussianBlur id="evQrI1MWBnR10-filter-blur-0" stdDeviation="2,2" result="result" />
					</filter>
					<linearGradient id="evQrI1MWBnR10-fill" x1="487.63" y1="682.4" x2="487.63" y2="499.28" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR10-fill-0" offset="0%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR10-fill-1" offset="67%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR10-fill-2" offset="100%" stop-color="rgb(72, 4, 156)" />
					</linearGradient>
					<filter id="evQrI1MWBnR11-filter" x="-400%" width="600%" y="-400%" height="600%">
						<feGaussianBlur id="evQrI1MWBnR11-filter-blur-0" stdDeviation="3,3" result="result" />
					</filter>
					<linearGradient id="evQrI1MWBnR11-fill" x1="752.381012" y1="703.75675" x2="747.672722" y2="572.589931" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR11-fill-0" offset="0%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR11-fill-1" offset="66%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR11-fill-2" offset="95.6816%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR11-fill-3" offset="100%" stop-color="rgba(72, 4, 156,0)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR12-stroke" x1="0.199815" y1="0.808809" x2="0.322402" y2="0.602973" spreadMethod="pad" gradientUnits="objectBoundingBox" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR12-stroke-0" offset="0%" stop-color="rgb(255,255,255)" />
						<stop id="evQrI1MWBnR12-stroke-1" offset="100%" stop-color="rgba(255,255,255,0)" />
					</linearGradient>
					<radialGradient id="evQrI1MWBnR14-fill" cx="0" cy="0" r="148.47" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1.21 0 0 0.15 -1.7628 1.4385)">
						<stop id="evQrI1MWBnR14-fill-0" offset="0%" stop-color="rgb(76,81,82)" />
						<stop id="evQrI1MWBnR14-fill-1" offset="100%" stop-color="rgba(95,99,99,0)" />
					</radialGradient>
					<filter id="evQrI1MWBnR15-filter" x="-400%" width="600%" y="-400%" height="600%">
						<feGaussianBlur id="evQrI1MWBnR15-filter-blur-0" stdDeviation="15,15" result="result" />
					</filter>
					<linearGradient id="evQrI1MWBnR15-fill" x1="0.362532" y1="0.984805" x2="0.75222" y2="0" spreadMethod="pad" gradientUnits="objectBoundingBox" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR15-fill-0" offset="0%" stop-color="rgb(83,85,86)" />
						<stop id="evQrI1MWBnR15-fill-1" offset="100%" stop-color="rgba(83,85,86,0)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR17-fill" x1="0" y1="-145.86" x2="0" y2="144.03" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR17-fill-0" offset="29%" stop-color="rgb(87,155,169)" />
						<stop id="evQrI1MWBnR17-fill-1" offset="100%" stop-color="rgb(68,197,223)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR18-fill" x1="0" y1="-113.05" x2="0" y2="111.22" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR18-fill-0" offset="0%" stop-color="rgb(66,152,170)" />
						<stop id="evQrI1MWBnR18-fill-1" offset="100%" stop-color="rgb(45,127,145)" />
					</linearGradient>
					<radialGradient id="evQrI1MWBnR19-fill" cx="0" cy="0" r="278.33" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.957873 0.287193 -0.287193 0.957873 -103.429321 115.140041)">
						<stop id="evQrI1MWBnR19-fill-0" offset="0%" stop-color="rgba(72, 4, 156,0)" />
						<stop id="evQrI1MWBnR19-fill-1" offset="100%" stop-color="rgb(72, 4, 156)" />
					</radialGradient>
					<linearGradient id="evQrI1MWBnR21-fill" x1="440.43" y1="222.31" x2="485.35" y2="534.75" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR21-fill-0" offset="0%" stop-color="rgb(239,239,239)" />
						<stop id="evQrI1MWBnR21-fill-1" offset="100%" stop-color="rgb(255,255,255)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR22-fill" x1="463.36" y1="526.3" x2="463.36" y2="236.3" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR22-fill-0" offset="12%" stop-color="rgb(188,188,188)" />
						<stop id="evQrI1MWBnR22-fill-1" offset="100%" stop-color="rgb(95,98,107)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR24-fill" x1="572.78" y1="525.09" x2="572.78" y2="209.93" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR24-fill-0" offset="0%" stop-color="rgb(71,161,179)" />
						<stop id="evQrI1MWBnR24-fill-1" offset="46%" stop-color="rgb(68,197,223)" />
						<stop id="evQrI1MWBnR24-fill-2" offset="100%" stop-color="rgb(142,237,255)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR25-fill" x1="611.65" y1="487.89" x2="611.65" y2="209.93" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR25-fill-0" offset="29%" stop-color="rgb(87,155,169)" />
						<stop id="evQrI1MWBnR25-fill-1" offset="100%" stop-color="rgb(68,197,223)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR26-fill" x1="625.87" y1="474.21" x2="625.87" y2="209.93" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR26-fill-0" offset="29%" stop-color="rgb(87,155,169)" />
						<stop id="evQrI1MWBnR26-fill-1" offset="100%" stop-color="rgb(68,197,223)" />
					</linearGradient>
					<radialGradient id="evQrI1MWBnR38-fill" cx="0" cy="0" r="218.96" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.304532 0.952502 -1.11443 0.356302 480.839 393.017752)">
						<stop id="evQrI1MWBnR38-fill-0" offset="33%" stop-color="rgba(142,237,255,0)" />
						<stop id="evQrI1MWBnR38-fill-1" offset="43%" stop-color="rgba(142,237,254,0.02)" />
						<stop id="evQrI1MWBnR38-fill-2" offset="50%" stop-color="rgba(141,235,251,0.06)" />
						<stop id="evQrI1MWBnR38-fill-3" offset="57%" stop-color="rgba(139,232,246,0.15)" />
						<stop id="evQrI1MWBnR38-fill-4" offset="64%" stop-color="rgba(137,229,239,0.26)" />
						<stop id="evQrI1MWBnR38-fill-5" offset="70%" stop-color="rgba(134,224,231,0.41)" />
						<stop id="evQrI1MWBnR38-fill-6" offset="76%" stop-color="rgba(130,218,220,0.6)" />
						<stop id="evQrI1MWBnR38-fill-7" offset="82%" stop-color="rgba(126,211,207,0.81)" />
						<stop id="evQrI1MWBnR38-fill-8" offset="87%" stop-color="rgb(122,205,196)" />
						<stop id="evQrI1MWBnR38-fill-9" offset="100%" stop-color="rgb(141,161,181)" />
					</radialGradient>
					<radialGradient id="evQrI1MWBnR39-fill" cx="0" cy="0" r="192.97" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 0.47 443.01 467.1513)">
						<stop id="evQrI1MWBnR39-fill-0" offset="35%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR39-fill-1" offset="61%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR39-fill-2" offset="84%" stop-color="rgb(72, 4, 156)" />
						<stop id="evQrI1MWBnR39-fill-3" offset="100%" stop-color="rgba(72, 4, 156,0)" />
					</radialGradient>
					<linearGradient id="evQrI1MWBnR40-fill" x1="135.03" y1="248.84" x2="240.62" y2="538.94" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR40-fill-0" offset="0%" stop-color="rgb(104,218,240)" />
						<stop id="evQrI1MWBnR40-fill-1" offset="54%" stop-color="rgb(68,197,223)" />
						<stop id="evQrI1MWBnR40-fill-2" offset="87%" stop-color="rgb(68,197,223)" />
						<stop id="evQrI1MWBnR40-fill-3" offset="100%" stop-color="rgb(79,175,195)" />
					</linearGradient>
					<linearGradient id="evQrI1MWBnR41-fill" x1="704.29" y1="248.84" x2="809.88" y2="538.94" spreadMethod="pad" gradientUnits="userSpaceOnUse" gradientTransform="matrix(1 0 0 1 0 0)">
						<stop id="evQrI1MWBnR41-fill-0" offset="0%" stop-color="rgb(104,218,240)" />
						<stop id="evQrI1MWBnR41-fill-1" offset="54%" stop-color="rgb(68,197,223)" />
						<stop id="evQrI1MWBnR41-fill-2" offset="87%" stop-color="rgb(68,197,223)" />
						<stop id="evQrI1MWBnR41-fill-3" offset="100%" stop-color="rgb(79,175,195)" />
					</linearGradient>
				</defs>
				<g id="evQrI1MWBnR2">
					<!-- remove this width="1066.55" height="202.73" -->
					<rect id="evQrI1MWBnR3" rx="0" ry="0" transform="matrix(1 0 0 1 0 388.1)" fill="url(#evQrI1MWBnR3-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR4" d="M196.66,388.1C196.66,241.47,315.54,122.59,462.18,122.59C608.82,122.59,727.69,241.47,727.69,388.1" fill="url(#evQrI1MWBnR4-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR5" d="M962.4,244.07C913.669155,292.800845,834.660845,292.800845,785.93,244.07C737.199155,195.339155,737.199155,116.330845,785.93,67.6" fill="none" stroke="url(#evQrI1MWBnR5-stroke)" stroke-width="80" stroke-miterlimit="10" />
				</g>
				<path id="evQrI1MWBnR6" d="M749.139041,638.950293C746.558872,652.818705,744.546554,654.631958,743.874482,666.841256C743.20241,679.050554,748.578982,687.11541,757.987981,687.451446C767.39698,687.787482,771.653433,676.586292,770.645326,665.497114C769.637219,654.407936,767.836518,652.032454,764.820707,638.838281C763.924612,634.917865,761.094056,630.988279,757.091886,630.997448C753.089716,631.006617,750.035136,634.133781,749.139041,638.950293Z" transform="matrix(1 0 0 1 -3.087486 73.235301)" opacity="0" fill="url(#evQrI1MWBnR6-fill)" stroke="none" stroke-width="1" />
				<g id="evQrI1MWBnR7" transform="matrix(0.406646 0 0 0.637111 223.352487 202.343123)">
					<path id="evQrI1MWBnR8" d="M785.93,565.665423C831.896401,564.28,895.93,549.81,909.34,539.97C913.562626,535.579134,914.274448,526.945022,909.34,523.86484C886.634903,509.691861,783.087242,508.983826,752.98,508.944211C700.76,508.874211,727.69,497.944211,630.36,497.944211C630.36,497.944211,420.7,491.664211,420.7,491.664211C395.7,493.104211,271.77,496.384211,234.19,496.384211C196.84,496.384211,235.82,517.124211,180.67,518.384211C100.069132,519.521821,87.807247,520.552376,68.950655,529.785318C64.201939,532.110479,62.661472,538.72324,64.13,544.59C73.225435,564.61,150.31,554.91,176.13,557.53C201.95,560.15,214.98,566.1,252.45,564.61C290.14,563.11,386.96,571.29,474.09,573.97C562.43,576.68,625.842171,575.777161,672.85,572.56C719.857829,569.342839,739.963599,567.050846,785.93,565.665423Z" transform="matrix(1.010056 0 0 1.040574 -4.903874 -16.356953)" fill="url(#evQrI1MWBnR8-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR9" d="M658.683436,584.943616C662.694819,587.635033,684.408911,597.269141,688.76883,597.631728C693.127974,597.994481,703.121814,597.234923,708.960463,596.962848C714.904581,596.685858,725.264671,596.635155,732.03449,595.709281C738.804309,594.783407,747.588696,593.840342,757.279074,590.152105C767.175192,586.385562,770.034249,584.960992,775.280392,583.21806C780.526535,581.475128,787.106623,580.313075,791.55105,579.844806C798.206616,579.143569,811.644666,578.603041,816.212406,577.795107C826.911302,575.902705,840.857353,566.952475,844.171363,563.726432" transform="matrix(1.763569 0 0 1 -578.035072 -14.682518)" opacity="0" fill="url(#evQrI1MWBnR9-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR10" d="M785.93,565.665423C831.896401,564.28,895.93,549.81,909.34,539.97C929.67,518.83,790.98,516.61,752.98,516.56C700.76,516.49,727.69,505.56,630.36,505.56C630.36,505.56,420.7,499.28,420.7,499.28C395.7,500.72,271.77,504,234.19,504C196.84,504,235.82,524.74,180.67,526C126,527.31,68.89,525.8,64.13,544.59C59.37,563.38,150.31,554.91,176.13,557.53C201.95,560.15,214.98,566.1,252.45,564.61C290.14,563.11,386.96,571.29,474.09,573.97C562.43,576.68,625.842171,575.777161,672.85,572.56C719.857829,569.342839,739.963599,567.050846,785.93,565.665423Z" filter="url(#evQrI1MWBnR10-filter)" fill="url(#evQrI1MWBnR10-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR11" d="M658.683436,584.943616C658.683436,584.943616,684.177862,589.84364,688.537781,590.206227C692.896925,590.56898,702.890765,589.809422,708.729414,589.537347C714.673532,589.260357,725.033622,589.209654,731.803441,588.28378C738.57326,587.357906,747.357647,586.414841,757.048025,582.726604C766.944143,578.960061,769.8032,577.535491,775.049343,575.792559C780.295486,574.049627,786.875574,572.887574,791.320001,572.419305C797.975567,571.718068,811.413617,571.17754,815.981357,570.369606C826.680253,568.477204,843.034239,564.527013,844.171363,563.726432" transform="matrix(1.763569 0 0 1 -578.035072 -14.682518)" opacity="0" filter="url(#evQrI1MWBnR11-filter)" fill="url(#evQrI1MWBnR11-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR12" d="M180.67,526C126,527.31,68.89,525.8,64.13,544.59C59.37,563.38,150.31,554.91,176.13,557.53C201.95,560.15,214.98,566.1,252.45,564.61C290.14,563.11,386.96,571.29,474.09,573.97C562.43,576.68,625.842171,575.777161,672.85,572.56C719.857829,569.342839,739.963599,567.050846,785.93,565.665423" transform="matrix(0.927629 0 0 1.015579 13.587813 -24.784578)" opacity="0.2" fill="none" stroke="url(#evQrI1MWBnR12-stroke)" stroke-width="16" stroke-linecap="round" />
				</g>
				<g id="evQrI1MWBnR13" transform="matrix(1 0 0 1 -19.92859 -7.559144)">
					<ellipse id="evQrI1MWBnR14" style="mix-blend-mode:multiply" rx="179.95" ry="22.19" transform="matrix(1 0 0 1 484.2 517.46)" fill="url(#evQrI1MWBnR14-fill)" stroke="none" stroke-width="1" />
					<path id="evQrI1MWBnR15" style="mix-blend-mode:multiply" d="M342.684998,507.596228C376.239753,526.320267,474.268393,537.503425,548.144998,532.623425C622.021603,527.743425,718.628005,503.615,698.669998,467.895C678.711991,432.175,518.189998,439.83,461.362604,448.050001C404.53521,456.270002,320.727974,495.343891,342.684998,507.596228Z" transform="matrix(1 0 0 1 0.000002 0)" opacity="0.8" filter="url(#evQrI1MWBnR15-filter)" fill="url(#evQrI1MWBnR15-fill)" stroke="none" stroke-width="2.4" />
					<g id="evQrI1MWBnR16">
						<ellipse id="evQrI1MWBnR17" rx="131.52" ry="145.21" transform="matrix(0.957873 -0.287193 0.287193 0.957873 463.359329 381.585432)" fill="url(#evQrI1MWBnR17-fill)" stroke="none" stroke-width="1" />
						<ellipse id="evQrI1MWBnR18" rx="101.75" ry="112.34" transform="matrix(0.96 -0.29 0.29 0.96 576.095933 348.681204)" fill="url(#evQrI1MWBnR18-fill)" stroke="none" stroke-width="1" />
						<ellipse id="evQrI1MWBnR19" rx="115.86" ry="127.92" transform="matrix(0.957873 -0.287193 0.287193 0.957873 461.362606 382.172091)" fill="url(#evQrI1MWBnR19-fill)" stroke="none" stroke-width="1" />
					</g>
					<g id="evQrI1MWBnR20">
						<path id="evQrI1MWBnR21" d="M601.43,340.22C576.19,256,493.9,206.28,417.63,229.14C341.36,252,300,338.8,325.24,423C350.48,507.2,432.77,557,509,534.09C585.23,511.18,626.67,424.43,601.43,340.22ZM498.08,504.75C436.79,523.12,370.66,483.15,350.37,415.48C330.08,347.81,363.37,278.05,424.62,259.67C485.87,241.29,552.05,281.27,572.33,348.94C592.61,416.61,559.38,486.37,498.08,504.75Z" fill="url(#evQrI1MWBnR21-fill)" stroke="none" stroke-width="1" />
						<path id="evQrI1MWBnR22" d="M471.18,529.65C410.18,529.65,354.18,484.65,334.82,420.14C311.2,341.35,349.64,260,420.5,238.72C431.854273,235.312124,443.645333,233.580523,455.5,233.58C516.5,233.58,572.5,278.58,591.86,343.09C603.35,381.44,600.66,421.49,584.28,455.86C568.06,489.86,540.33,514.27,506.18,524.51C494.825945,527.918856,483.03474,529.650478,471.18,529.65ZM455.05,245.21C443.77179,245.209205,432.553747,246.853171,421.75,250.09C355.27,270,319,345.5,340.79,418.35C358.6,477.74,410.79,519.21,467.66,519.21C478.938116,519.209513,490.155974,517.565574,500.96,514.33C533.34,504.62,559.57,481.64,574.83,449.63C589.92,417.96,592.44,381.18,581.91,346.07C564.11,286.68,511.94,245.21,455.05,245.21Z" opacity="0.25" fill="url(#evQrI1MWBnR22-fill)" stroke="none" stroke-width="1" />
					</g>
					<g id="evQrI1MWBnR23">
						<path id="evQrI1MWBnR24" d="M698.67,310.68C679.05,245.24,619.84,203.86,560.61,210.68L560.61,210.68L440.46,224.44L440.46,224.44C509.67,216.5,578.68,264.36,601.46,340.21C624.11,415.76,593.13,493.39,531.46,525.07L531.46,525.07L639,469.85L639,469.85C691.8,442.73,718.21,375.87,698.67,310.68Z" fill="url(#evQrI1MWBnR24-fill)" stroke="none" stroke-width="1" />
						<path id="evQrI1MWBnR25" d="M639,469.84C691.8,442.73,718.21,375.84,698.67,310.68C679.05,245.24,619.84,203.86,560.61,210.68L560.61,210.68L518.19,215.55C576.19,218.85,630.26,261.88,649.48,325.99C668.24,388.58,648.21,452.66,603.87,487.92L639.01,469.92Z" opacity="0.5" fill="url(#evQrI1MWBnR25-fill)" stroke="none" stroke-width="1" />
						<path id="evQrI1MWBnR26" d="M698.67,310.68C679.05,245.24,619.84,203.86,560.61,210.68L560.61,210.68L546.61,212.28C602.06,216.52,653.35,258,671.76,319.4C689.55,378.75,671.44,439.47,630.51,474.21L639.01,469.85L639.01,469.85C691.8,442.73,718.21,375.87,698.67,310.68Z" fill="url(#evQrI1MWBnR26-fill)" stroke="none" stroke-width="1" />
						<g id="evQrI1MWBnR27" mask="url(#evQrI1MWBnR34)">
							<g id="evQrI1MWBnR28" transform="matrix(0.977528 -0.210807 0.210807 0.977528 -73.104553 105.542046)">
								<polygon id="evQrI1MWBnR31" points="628.65,302.71 637.55,317.63 655.79,299.7 647.95,287.34 628.65,302.71" fill="rgb(95,98,107)" stroke="none" stroke-width="1" />
								<path id="evQrI1MWBnR32" d="M587.05,269.55C588.86,266.92,596.11,269.81,600.69,275.55C605.27,281.29,605.04,285.03,602.78,286.24C600.52,287.45,596,284,592.49,280.56C588.98,277.12,585.43,271.91,587.05,269.55Z" fill="rgb(111,114,123)" stroke="none" stroke-width="1" />
								<path id="evQrI1MWBnR33" d="M637.22,260.52C638.93,258.04,645.75,260.77,650.06,266.2C654.37,271.63,654.16,275.12,652.06,276.25C649.96,277.38,645.63,274.15,642.37,270.88C639.11,267.61,635.7,262.74,637.22,260.52Z" fill="rgb(114,117,126)" stroke="none" stroke-width="1" />
							</g>
							<mask id="evQrI1MWBnR34" mask-type="luminance">
								<path id="evQrI1MWBnR35" style="mix-blend-mode:color" d="M698.67,310.68C679.05,245.24,619.84,203.86,560.61,210.68L560.61,210.68L440.46,224.44L440.46,224.44C509.67,216.5,578.68,264.36,601.46,340.21C624.11,415.76,593.13,493.39,531.46,525.07L531.46,525.07L639,469.85L639,469.85C691.8,442.73,718.21,375.87,698.67,310.68Z" fill="rgb(255,255,255)" stroke="none" stroke-width="1" />
							</mask>
						</g>
						<path id="evQrI1MWBnR36" d="M561.615997,527.94542C587.516991,515.857345,613.861731,480.089109,622.442752,447.462645L648.337964,437.569033C634.575623,483.821969,599.987985,513.229153,585.051476,519.933663Z" transform="matrix(0.989138 -0.146991 0.146991 0.989138 -51.02138 59.460156)" fill="rgb(185,186,186)" stroke="none" stroke-width="1" />
						<path id="evQrI1MWBnR37" d="M589.37969,510.149874C615.9258,494.03429,657.911619,455.876889,663.131561,384.794632L681.375376,378.623921C678.163539,453.079043,630.079955,494.845148,604.075234,506.652563Z" transform="matrix(0.970998 -0.239088 0.239088 0.970998 -77.180281 126.678455)" fill="rgb(78,82,91)" stroke="none" stroke-width="1" />
						<path id="evQrI1MWBnR38" style="mix-blend-mode:color" d="M698.67,310.68C679.05,245.24,619.84,203.86,560.61,210.68L560.61,210.68L440.46,224.44L440.46,224.44C509.67,216.5,578.68,264.36,601.46,340.21C624.11,415.76,593.13,493.39,531.46,525.07L531.46,525.07L639,469.85L639,469.85C691.8,442.73,718.21,375.87,698.67,310.68Z" fill="url(#evQrI1MWBnR38-fill)" stroke="none" stroke-width="1" />
					</g>
					<path id="evQrI1MWBnR39" d="M506.570001,540.490001C506.570001,531.250001,506.180001,524.2,506.180001,501.56C535.640001,493,562.554999,460.865001,574.274999,423.000002L503.062615,423C503.062615,423,418.04,444.88,378.13,455.86C343.51,465.39,342.685,522.07,342.685,535.010642L342.685,557.380642L506.570001,558.449749Z" fill="url(#evQrI1MWBnR39-fill)" stroke="none" stroke-width="1" />
				</g>
				<path id="evQrI1MWBnR40" d="M222.65,418.3L232.71,345.23L270.34,345.23L270.34,418.3L313.66,418.3L313.66,459.87L270.34,459.87L270.34,528.12L222.65,528.12L222.65,459.87L94.89,459.87L94.89,414.36L181.52,231.91L229.21,231.91L142.14,418.3Z" transform="matrix(1 0 0 1 29.096925 1.33291)" fill="url(#evQrI1MWBnR40-fill)" stroke="none" stroke-width="1" />
				<path id="evQrI1MWBnR41" d="M791.91,418.3L802,345.23L839.6,345.23L839.6,418.3L882.92,418.3L882.92,459.87L839.6,459.87L839.6,528.12L791.91,528.12L791.91,459.87L664.15,459.87L664.15,414.36L750.78,231.91L798.47,231.91L711.4,418.3Z" transform="matrix(1 0 0 1 8.076333 0)" fill="url(#evQrI1MWBnR41-fill)" stroke="none" stroke-width="1" />
				<script>
					<![CDATA[
					! function(t, n) {
						"object" == typeof exports && "undefined" != typeof module ? module.exports = n() : "function" == typeof define && define.amd ? define(n) : ((t = "undefined" != typeof globalThis ? globalThis : t || self).__SVGATOR_PLAYER__ = t.__SVGATOR_PLAYER__ || {}, t.__SVGATOR_PLAYER__["91c80d77"] = n())
					}(this, (function() {
						"use strict";

						function t(t, n) {
							var e = Object.keys(t);
							if (Object.getOwnPropertySymbols) {
								var r = Object.getOwnPropertySymbols(t);
								n && (r = r.filter((function(n) {
									return Object.getOwnPropertyDescriptor(t, n).enumerable
								}))), e.push.apply(e, r)
							}
							return e
						}

						function n(n) {
							for (var e = 1; e < arguments.length; e++) {
								var r = null != arguments[e] ? arguments[e] : {};
								e % 2 ? t(Object(r), !0).forEach((function(t) {
									o(n, t, r[t])
								})) : Object.getOwnPropertyDescriptors ? Object.defineProperties(n, Object.getOwnPropertyDescriptors(r)) : t(Object(r)).forEach((function(t) {
									Object.defineProperty(n, t, Object.getOwnPropertyDescriptor(r, t))
								}))
							}
							return n
						}

						function e(t) {
							return (e = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
								return typeof t
							} : function(t) {
								return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
							})(t)
						}

						function r(t, n) {
							if (!(t instanceof n)) throw new TypeError("Cannot call a class as a function")
						}

						function i(t, n) {
							for (var e = 0; e < n.length; e++) {
								var r = n[e];
								r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
							}
						}

						function u(t, n, e) {
							return n && i(t.prototype, n), e && i(t, e), t
						}

						function o(t, n, e) {
							return n in t ? Object.defineProperty(t, n, {
								value: e,
								enumerable: !0,
								configurable: !0,
								writable: !0
							}) : t[n] = e, t
						}

						function a(t) {
							return (a = Object.setPrototypeOf ? Object.getPrototypeOf : function(t) {
								return t.__proto__ || Object.getPrototypeOf(t)
							})(t)
						}

						function l(t, n) {
							return (l = Object.setPrototypeOf || function(t, n) {
								return t.__proto__ = n, t
							})(t, n)
						}

						function s() {
							if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
							if (Reflect.construct.sham) return !1;
							if ("function" == typeof Proxy) return !0;
							try {
								return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], (function() {}))), !0
							} catch (t) {
								return !1
							}
						}

						function f(t, n, e) {
							return (f = s() ? Reflect.construct : function(t, n, e) {
								var r = [null];
								r.push.apply(r, n);
								var i = new(Function.bind.apply(t, r));
								return e && l(i, e.prototype), i
							}).apply(null, arguments)
						}

						function c(t, n) {
							if (n && ("object" == typeof n || "function" == typeof n)) return n;
							if (void 0 !== n) throw new TypeError("Derived constructors may only return object or undefined");
							return function(t) {
								if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
								return t
							}(t)
						}

						function h(t, n, e) {
							return (h = "undefined" != typeof Reflect && Reflect.get ? Reflect.get : function(t, n, e) {
								var r = function(t, n) {
									for (; !Object.prototype.hasOwnProperty.call(t, n) && null !== (t = a(t)););
									return t
								}(t, n);
								if (r) {
									var i = Object.getOwnPropertyDescriptor(r, n);
									return i.get ? i.get.call(e) : i.value
								}
							})(t, n, e || t)
						}

						function v(t) {
							return function(t) {
								if (Array.isArray(t)) return d(t)
							}(t) || function(t) {
								if ("undefined" != typeof Symbol && null != t[Symbol.iterator] || null != t["@@iterator"]) return Array.from(t)
							}(t) || function(t, n) {
								if (!t) return;
								if ("string" == typeof t) return d(t, n);
								var e = Object.prototype.toString.call(t).slice(8, -1);
								"Object" === e && t.constructor && (e = t.constructor.name);
								if ("Map" === e || "Set" === e) return Array.from(t);
								if ("Arguments" === e || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e)) return d(t, n)
							}(t) || function() {
								throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
							}()
						}

						function d(t, n) {
							(null == n || n > t.length) && (n = t.length);
							for (var e = 0, r = new Array(n); e < n; e++) r[e] = t[e];
							return r
						}
						var y = g(Math.pow(10, -6));

						function g(t) {
							var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 6;
							if (Number.isInteger(t)) return t;
							var e = Math.pow(10, n);
							return Math.round((+t + Number.EPSILON) * e) / e
						}

						function p(t, n) {
							var e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : y;
							return Math.abs(t - n) < e
						}
						var m = Math.PI / 180;

						function b(t) {
							return t
						}

						function w(t, n, e) {
							var r = 1 - e;
							return 3 * e * r * (t * r + n * e) + e * e * e
						}

						function A() {
							var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0,
								n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0,
								e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1,
								r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 1;
							return t < 0 || t > 1 || e < 0 || e > 1 ? null : p(t, n) && p(e, r) ? b : function(i) {
								if (i <= 0) return t > 0 ? i * n / t : 0 === n && e > 0 ? i * r / e : 0;
								if (i >= 1) return e < 1 ? 1 + (i - 1) * (r - 1) / (e - 1) : 1 === e && t < 1 ? 1 + (i - 1) * (n - 1) / (t - 1) : 1;
								for (var u, o = 0, a = 1; o < a;) {
									var l = w(t, e, u = (o + a) / 2);
									if (p(i, l)) break;
									l < i ? o = u : a = u
								}
								return w(n, r, u)
							}
						}

						function x() {
							return 1
						}

						function k(t) {
							return 1 === t ? 1 : 0
						}

						function _() {
							var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 1,
								n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0;
							if (1 === t) {
								if (0 === n) return k;
								if (1 === n) return x
							}
							var e = 1 / t;
							return function(t) {
								return t >= 1 ? 1 : (t += n * e) - t % e
							}
						}
						var S = Math.sin,
							O = Math.cos,
							M = Math.acos,
							E = Math.asin,
							j = Math.tan,
							P = Math.atan2,
							I = Math.PI / 180,
							B = 180 / Math.PI,
							R = Math.sqrt,
							T = function() {
								function t() {
									var n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 1,
										e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0,
										i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0,
										u = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 1,
										o = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : 0,
										a = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : 0;
									r(this, t), this.m = [n, e, i, u, o, a], this.i = null, this.w = null, this.s = null
								}
								return u(t, [{
									key: "determinant",
									get: function() {
										var t = this.m;
										return t[0] * t[3] - t[1] * t[2]
									}
								}, {
									key: "isIdentity",
									get: function() {
										if (null === this.i) {
											var t = this.m;
											this.i = 1 === t[0] && 0 === t[1] && 0 === t[2] && 1 === t[3] && 0 === t[4] && 0 === t[5]
										}
										return this.i
									}
								}, {
									key: "point",
									value: function(t, n) {
										var e = this.m;
										return {
											x: e[0] * t + e[2] * n + e[4],
											y: e[1] * t + e[3] * n + e[5]
										}
									}
								}, {
									key: "translateSelf",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0,
											n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0;
										if (!t && !n) return this;
										var e = this.m;
										return e[4] += e[0] * t + e[2] * n, e[5] += e[1] * t + e[3] * n, this.w = this.s = this.i = null, this
									}
								}, {
									key: "rotateSelf",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0;
										if (t %= 360) {
											var n = S(t *= I),
												e = O(t),
												r = this.m,
												i = r[0],
												u = r[1];
											r[0] = i * e + r[2] * n, r[1] = u * e + r[3] * n, r[2] = r[2] * e - i * n, r[3] = r[3] * e - u * n, this.w = this.s = this.i = null
										}
										return this
									}
								}, {
									key: "scaleSelf",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 1,
											n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 1;
										if (1 !== t || 1 !== n) {
											var e = this.m;
											e[0] *= t, e[1] *= t, e[2] *= n, e[3] *= n, this.w = this.s = this.i = null
										}
										return this
									}
								}, {
									key: "skewSelf",
									value: function(t, n) {
										if (n %= 360, (t %= 360) || n) {
											var e = this.m,
												r = e[0],
												i = e[1],
												u = e[2],
												o = e[3];
											t && (t = j(t * I), e[2] += r * t, e[3] += i * t), n && (n = j(n * I), e[0] += u * n, e[1] += o * n), this.w = this.s = this.i = null
										}
										return this
									}
								}, {
									key: "resetSelf",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 1,
											n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0,
											e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0,
											r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 1,
											i = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : 0,
											u = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : 0,
											o = this.m;
										return o[0] = t, o[1] = n, o[2] = e, o[3] = r, o[4] = i, o[5] = u, this.w = this.s = this.i = null, this
									}
								}, {
									key: "recomposeSelf",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null,
											n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null,
											e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null,
											r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null,
											i = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : null;
										return this.isIdentity || this.resetSelf(), t && (t.x || t.y) && this.translateSelf(t.x, t.y), n && this.rotateSelf(n), e && (e.x && this.skewSelf(e.x, 0), e.y && this.skewSelf(0, e.y)), !r || 1 === r.x && 1 === r.y || this.scaleSelf(r.x, r.y), i && (i.x || i.y) && this.translateSelf(i.x, i.y), this
									}
								}, {
									key: "decompose",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0,
											n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0,
											e = this.m,
											r = e[0] * e[0] + e[1] * e[1],
											i = [
												[e[0], e[1]],
												[e[2], e[3]]
											],
											u = R(r);
										if (0 === u) return {
											origin: {
												x: g(e[4]),
												y: g(e[5])
											},
											translate: {
												x: g(t),
												y: g(n)
											},
											scale: {
												x: 0,
												y: 0
											},
											skew: {
												x: 0,
												y: 0
											},
											rotate: 0
										};
										i[0][0] /= u, i[0][1] /= u;
										var o = e[0] * e[3] - e[1] * e[2] < 0;
										o && (u = -u);
										var a = i[0][0] * i[1][0] + i[0][1] * i[1][1];
										i[1][0] -= i[0][0] * a, i[1][1] -= i[0][1] * a;
										var l = R(i[1][0] * i[1][0] + i[1][1] * i[1][1]);
										if (0 === l) return {
											origin: {
												x: g(e[4]),
												y: g(e[5])
											},
											translate: {
												x: g(t),
												y: g(n)
											},
											scale: {
												x: g(u),
												y: 0
											},
											skew: {
												x: 0,
												y: 0
											},
											rotate: 0
										};
										i[1][0] /= l, i[1][1] /= l, a /= l;
										var s = 0;
										return i[1][1] < 0 ? (s = M(i[1][1]) * B, i[0][1] < 0 && (s = 360 - s)) : s = E(i[0][1]) * B, o && (s = -s), a = P(a, R(i[0][0] * i[0][0] + i[0][1] * i[0][1])) * B, o && (a = -a), {
											origin: {
												x: g(e[4]),
												y: g(e[5])
											},
											translate: {
												x: g(t),
												y: g(n)
											},
											scale: {
												x: g(u),
												y: g(l)
											},
											skew: {
												x: g(a),
												y: 0
											},
											rotate: g(s)
										}
									}
								}, {
									key: "clone",
									value: function() {
										var t = this.m;
										return new this.constructor(t[0], t[1], t[2], t[3], t[4], t[5])
									}
								}, {
									key: "toString",
									value: function() {
										var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : " ";
										return null === this.s && (this.s = "matrix(" + this.m.map((function(t) {
											return g(t)
										})).join(t) + ")"), this.s
									}
								}], [{
									key: "create",
									value: function(t) {
										return t ? Array.isArray(t) ? f(this, v(t)) : t instanceof this ? t.clone() : (new this).recomposeSelf(t.origin, t.rotate, t.skew, t.scale, t.translate) : new this
									}
								}]), t
							}();

						function N(t, n, e) {
							return t >= .5 ? e : n
						}

						function C(t, n, e) {
							return 0 === t || n === e ? n : t * (e - n) + n
						}

						function F(t, n, e) {
							var r = C(t, n, e);
							return r <= 0 ? 0 : r
						}

						function L(t, n, e) {
							var r = C(t, n, e);
							return r <= 0 ? 0 : r >= 1 ? 1 : r
						}

						function q(t, n, e) {
							return 0 === t ? n : 1 === t ? e : {
								x: C(t, n.x, e.x),
								y: C(t, n.y, e.y)
							}
						}

						function V(t, n, e) {
							return 0 === t ? n : 1 === t ? e : {
								x: F(t, n.x, e.x),
								y: F(t, n.y, e.y)
							}
						}

						function D(t, n, e) {
							var r = function(t, n, e) {
								return Math.round(C(t, n, e))
							}(t, n, e);
							return r <= 0 ? 0 : r >= 255 ? 255 : r
						}

						function z(t, n, e) {
							return 0 === t ? n : 1 === t ? e : {
								r: D(t, n.r, e.r),
								g: D(t, n.g, e.g),
								b: D(t, n.b, e.b),
								a: C(t, null == n.a ? 1 : n.a, null == e.a ? 1 : e.a)
							}
						}

						function Y(t, n, e) {
							var r = n.length;
							if (r !== e.length) return N(t, n, e);
							for (var i = new Array(r), u = 0; u < r; u++) i[u] = C(t, n[u], e[u]);
							return i
						}

						function G(t, n) {
							for (var e = [], r = 0; r < t; r++) e.push(n);
							return e
						}

						function U(t, n) {
							if (--n <= 0) return t;
							var e = (t = Object.assign([], t)).length;
							do {
								for (var r = 0; r < e; r++) t.push(t[r])
							} while (--n > 0);
							return t
						}
						var $, W = function() {
								function t(n) {
									r(this, t), this.list = n, this.length = n.length
								}
								return u(t, [{
									key: "setAttribute",
									value: function(t, n) {
										for (var e = this.list, r = 0; r < this.length; r++) e[r].setAttribute(t, n)
									}
								}, {
									key: "removeAttribute",
									value: function(t) {
										for (var n = this.list, e = 0; e < this.length; e++) n[e].removeAttribute(t)
									}
								}, {
									key: "style",
									value: function(t, n) {
										for (var e = this.list, r = 0; r < this.length; r++) e[r].style[t] = n
									}
								}]), t
							}(),
							H = /-./g,
							Q = function(t, n) {
								return n.toUpperCase()
							};

						function X(t) {
							return "function" == typeof t ? t : N
						}

						function J(t) {
							return t ? "function" == typeof t ? t : Array.isArray(t) ? function(t) {
								var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : b;
								if (!Array.isArray(t)) return n;
								switch (t.length) {
									case 1:
										return _(t[0]) || n;
									case 2:
										return _(t[0], t[1]) || n;
									case 4:
										return A(t[0], t[1], t[2], t[3]) || n
								}
								return n
							}(t, null) : function(t, n) {
								var e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : b;
								switch (t) {
									case "linear":
										return b;
									case "steps":
										return _(n.steps || 1, n.jump || 0) || e;
									case "bezier":
									case "cubic-bezier":
										return A(n.x1 || 0, n.y1 || 0, n.x2 || 0, n.y2 || 0) || e
								}
								return e
							}(t.type, t.value, null) : null
						}

						function Z(t, n, e) {
							var r = arguments.length > 3 && void 0 !== arguments[3] && arguments[3],
								i = n.length - 1;
							if (t <= n[0].t) return r ? [0, 0, n[0].v] : n[0].v;
							if (t >= n[i].t) return r ? [i, 1, n[i].v] : n[i].v;
							var u, o = n[0],
								a = null;
							for (u = 1; u <= i; u++) {
								if (!(t > n[u].t)) {
									a = n[u];
									break
								}
								o = n[u]
							}
							return null == a ? r ? [i, 1, n[i].v] : n[i].v : o.t === a.t ? r ? [u, 1, a.v] : a.v : (t = (t - o.t) / (a.t - o.t), o.e && (t = o.e(t)), r ? [u, t, e(t, o.v, a.v)] : e(t, o.v, a.v))
						}

						function K(t, n) {
							var e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null;
							return t && t.length ? "function" != typeof n ? null : ("function" != typeof e && (e = null), function(r) {
								var i = Z(r, t, n);
								return null != i && e && (i = e(i)), i
							}) : null
						}

						function tt(t, n) {
							return t.t - n.t
						}

						function nt(t, n, r, i, u) {
							var o, a = "@" === r[0],
								l = "#" === r[0],
								s = $[r],
								f = N;
							switch (a ? (o = r.substr(1), r = o.replace(H, Q)) : l && (r = r.substr(1)), e(s)) {
								case "function":
									if (f = s(i, u, Z, J, r, a, n, t), l) return f;
									break;
								case "string":
									f = K(i, X(s));
									break;
								case "object":
									if ((f = K(i, X(s.i), s.f)) && "function" == typeof s.u) return s.u(n, f, r, a, t)
							}
							return f ? function(t, n, e) {
								if (arguments.length > 3 && void 0 !== arguments[3] && arguments[3]) return t instanceof W ? function(r) {
									return t.style(n, e(r))
								} : function(r) {
									return t.style[n] = e(r)
								};
								if (Array.isArray(n)) {
									var r = n.length;
									return function(i) {
										var u = e(i);
										if (null == u)
											for (var o = 0; o < r; o++) t[o].removeAttribute(n);
										else
											for (var a = 0; a < r; a++) t[a].setAttribute(n, u)
									}
								}
								return function(r) {
									var i = e(r);
									null == i ? t.removeAttribute(n) : t.setAttribute(n, i)
								}
							}(n, r, f, a) : null
						}

						function et(t, n, r, i) {
							if (!i || "object" !== e(i)) return null;
							var u = null,
								o = null;
							return Array.isArray(i) ? o = function(t) {
								if (!t || !t.length) return null;
								for (var n = 0; n < t.length; n++) t[n].e && (t[n].e = J(t[n].e));
								return t.sort(tt)
							}(i) : (o = i.keys, u = i.data || null), o ? nt(t, n, r, o, u) : null
						}

						function rt(t, n, e) {
							if (!e) return null;
							var r = [];
							for (var i in e)
								if (e.hasOwnProperty(i)) {
									var u = et(t, n, i, e[i]);
									u && r.push(u)
								} return r.length ? r : null
						}

						function it(t, n) {
							if (!n.duration || n.duration < 0) return null;
							var e = function(t, n) {
								if (!n) return null;
								var e = [];
								if (Array.isArray(n))
									for (var r = n.length, i = 0; i < r; i++) {
										var u = n[i];
										if (2 === u.length) {
											var o = null;
											if ("string" == typeof u[0]) o = t.getElementById(u[0]);
											else if (Array.isArray(u[0])) {
												o = [];
												for (var a = 0; a < u[0].length; a++)
													if ("string" == typeof u[0][a]) {
														var l = t.getElementById(u[0][a]);
														l && o.push(l)
													} o = o.length ? 1 === o.length ? o[0] : new W(o) : null
											}
											if (o) {
												var s = rt(t, o, u[1]);
												s && (e = e.concat(s))
											}
										}
									} else
										for (var f in n)
											if (n.hasOwnProperty(f)) {
												var c = t.getElementById(f);
												if (c) {
													var h = rt(t, c, n[f]);
													h && (e = e.concat(h))
												}
											} return e.length ? e : null
							}(t, n.elements);
							return e ? function(t, n) {
								var e = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1 / 0,
									r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 1,
									i = arguments.length > 4 && void 0 !== arguments[4] && arguments[4],
									u = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : 1,
									o = t.length,
									a = r > 0 ? n : 0;
								i && e % 2 == 0 && (a = n - a);
								var l = null;
								return function(s, f) {
									var c = s % n,
										h = 1 + (s - c) / n;
									f *= r, i && h % 2 == 0 && (f = -f);
									var v = !1;
									if (h > e) c = a, v = !0, -1 === u && (c = r > 0 ? 0 : n);
									else if (f < 0 && (c = n - c), c === l) return !1;
									l = c;
									for (var d = 0; d < o; d++) t[d](c);
									return v
								}
							}(e, n.duration, n.iterations || 1 / 0, n.direction || 1, !!n.alternate, n.fill || 1) : null
						}

						function ut(t) {
							return +("0x" + (t.replace(/[^0-9a-fA-F]+/g, "") || 27))
						}

						function ot(t, n, e) {
							return !t || !e || n > t.length ? t : t.substring(0, n) + ot(t.substring(n + 1), e, e)
						}

						function at(t) {
							var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 27;
							return !t || t % n ? t % n : at(t / n, n)
						}

						function lt(t, n, e) {
							if (t && t.length) {
								var r = ut(e),
									i = ut(n),
									u = at(r) + 5,
									o = ot(t, at(r, 5), u);
								return o = o.replace(/\x7c$/g, "==").replace(/\x2f$/g, "="), o = function(t, n, e) {
									var r = +("0x" + t.substring(0, 4));
									t = t.substring(4);
									for (var i = n % r + e % 27, u = [], o = 0; o < t.length; o += 2)
										if ("|" !== t[o]) {
											var a = +("0x" + t[o] + t[o + 1]) - i;
											u.push(a)
										} else {
											var l = +("0x" + t.substring(o + 1, o + 1 + 4)) - i;
											o += 3, u.push(l)
										} return String.fromCharCode.apply(String, u)
								}(o = (o = atob(o)).replace(/[\x41-\x5A]/g, ""), i, r), o = JSON.parse(o)
							}
						}
						Number.isInteger || (Number.isInteger = function(t) {
							return "number" == typeof t && isFinite(t) && Math.floor(t) === t
						}), Number.EPSILON || (Number.EPSILON = 2220446049250313e-31);
						var st = function() {
							function t(n, e) {
								var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
								r(this, t), this._id = 0, this._running = !1, this._rollingBack = !1, this._animations = n, this.duration = e.duration, this.alternate = e.alternate, this.fill = e.fill, this.iterations = e.iterations, this.direction = i.direction || 1, this.speed = i.speed || 1, this.fps = i.fps || 100, this.offset = i.offset || 0, this.rollbackStartOffset = 0
							}
							return u(t, [{
								key: "_rollback",
								value: function() {
									var t = this,
										n = 1 / 0,
										e = null;
									this.rollbackStartOffset = this.offset, this._rollingBack || (this._rollingBack = !0, this._running = !0);
									this._id = window.requestAnimationFrame((function r(i) {
										if (t._rollingBack) {
											null == e && (e = i);
											var u = i - e,
												o = t.rollbackStartOffset - u,
												a = Math.round(o * t.speed);
											if (a > t.duration && n != 1 / 0) {
												var l = !!t.alternate && a / t.duration % 2 > 1,
													s = a % t.duration;
												a = (s += l ? t.duration : 0) || t.duration
											}
											var f = t.fps ? 1e3 / t.fps : 0,
												c = Math.max(0, a);
											if (c < n - f) {
												t.offset = c, n = c;
												for (var h = t._animations, v = h.length, d = 0; d < v; d++) h[d](c, t.direction)
											}
											var y = !1;
											if (t.iterations > 0 && -1 === t.fill) {
												var g = t.iterations * t.duration,
													p = g == a;
												a = p ? 0 : a, t.offset = p ? 0 : t.offset, y = a > g
											}
											a > 0 && t.offset >= a && !y ? t._id = window.requestAnimationFrame(r) : t.stop()
										}
									}))
								}
							}, {
								key: "_start",
								value: function() {
									var t = this,
										n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0,
										e = -1 / 0,
										r = null,
										i = {},
										u = function u(o) {
											t._running = !0, null == r && (r = o);
											var a = Math.round((o - r + n) * t.speed),
												l = t.fps ? 1e3 / t.fps : 0;
											if (a > e + l && !t._rollingBack) {
												t.offset = a, e = a;
												for (var s = t._animations, f = s.length, c = 0, h = 0; h < f; h++) i[h] ? c++ : (i[h] = s[h](a, t.direction), i[h] && c++);
												if (c === f) return void t._stop()
											}
											t._id = window.requestAnimationFrame(u)
										};
									this._id = window.requestAnimationFrame(u)
								}
							}, {
								key: "_stop",
								value: function() {
									this._id && window.cancelAnimationFrame(this._id), this._running = !1, this._rollingBack = !1
								}
							}, {
								key: "play",
								value: function() {
									!this._rollingBack && this._running || (this._rollingBack = !1, this.rollbackStartOffset > this.duration && (this.offset = this.rollbackStartOffset - (this.rollbackStartOffset - this.offset) % this.duration, this.rollbackStartOffset = 0), this._start(this.offset))
								}
							}, {
								key: "stop",
								value: function() {
									this._stop(), this.offset = 0, this.rollbackStartOffset = 0;
									var t = this.direction,
										n = this._animations;
									window.requestAnimationFrame((function() {
										for (var e = 0; e < n.length; e++) n[e](0, t)
									}))
								}
							}, {
								key: "reachedToEnd",
								value: function() {
									return this.iterations > 0 && this.offset >= this.iterations * this.duration
								}
							}, {
								key: "restart",
								value: function() {
									this._stop(), this.offset = 0, this._start()
								}
							}, {
								key: "pause",
								value: function() {
									this._stop()
								}
							}, {
								key: "reverse",
								value: function() {
									this.direction = -this.direction
								}
							}], [{
								key: "build",
								value: function(e, r) {
									return delete e.animationSettings, e.options = lt(e.options, e.root, "91c80d77"), e.animations.map((function(t) {
										var r = lt(t.s, e.root, "91c80d77");
										for (var i in delete t.s, e.animationSettings || (e.animationSettings = n({}, r)), r) r.hasOwnProperty(i) && (t[i] = r[i])
									})), (e = function(t, n) {
										if ($ = n, !t || !t.root || !Array.isArray(t.animations)) return null;
										for (var e = document.getElementsByTagName("svg"), r = !1, i = 0; i < e.length; i++)
											if (e[i].id === t.root && !e[i].svgatorAnimation) {
												(r = e[i]).svgatorAnimation = !0;
												break
											} if (!r) return null;
										var u = t.animations.map((function(t) {
											return it(r, t)
										})).filter((function(t) {
											return !!t
										}));
										return u.length ? {
											element: r,
											animations: u,
											animationSettings: t.animationSettings,
											options: t.options || void 0
										} : null
									}(e, r)) ? {
										el: e.element,
										options: e.options || {},
										player: new t(e.animations, e.animationSettings, e.options)
									} : null
								}
							}, {
								key: "push",
								value: function(t) {
									return this.build(t)
								}
							}, {
								key: "init",
								value: function() {
									var t = this,
										n = window.__SVGATOR_PLAYER__ && window.__SVGATOR_PLAYER__["91c80d77"];
									Array.isArray(n) && n.splice(0).forEach((function(n) {
										return t.build(n)
									}))
								}
							}]), t
						}();
						! function() {
							for (var t = 0, n = ["ms", "moz", "webkit", "o"], e = 0; e < n.length && !window.requestAnimationFrame; ++e) window.requestAnimationFrame = window[n[e] + "RequestAnimationFrame"], window.cancelAnimationFrame = window[n[e] + "CancelAnimationFrame"] || window[n[e] + "CancelRequestAnimationFrame"];
							window.requestAnimationFrame || (window.requestAnimationFrame = function(n) {
								var e = Date.now(),
									r = Math.max(0, 16 - (e - t)),
									i = window.setTimeout((function() {
										n(e + r)
									}), r);
								return t = e + r, i
							}, window.cancelAnimationFrame = window.clearTimeout)
						}();
						var ft = function(t, n) {
								var e = !1,
									r = null;
								return function(i) {
									e && clearTimeout(e), e = setTimeout((function() {
										return function() {
											for (var i = 0, u = window.innerHeight, o = 0, a = window.innerWidth, l = t.parentNode; l instanceof Element;) {
												var s = window.getComputedStyle(l);
												if ("visible" !== s.overflowY || "visible" !== s.overflowX) {
													var f = l.getBoundingClientRect();
													"visible" !== s.overflowY && (i = Math.max(i, f.top), u = Math.min(u, f.bottom)), "visible" !== s.overflowX && (o = Math.max(o, f.left), a = Math.min(a, f.right))
												}
												if (l === l.parentNode) break;
												l = l.parentNode
											}
											e = !1;
											var c = t.getBoundingClientRect(),
												h = Math.min(c.height, Math.max(0, i - c.top)),
												v = Math.min(c.height, Math.max(0, c.bottom - u)),
												d = Math.min(c.width, Math.max(0, o - c.left)),
												y = Math.min(c.width, Math.max(0, c.right - a)),
												g = (c.height - h - v) / c.height,
												p = (c.width - d - y) / c.width,
												m = Math.round(g * p * 100);
											null !== r && r === m || (r = m, n(m))
										}()
									}), 100)
								}
							},
							ct = function() {
								function t(n, e, i) {
									r(this, t), e = Math.max(1, e || 1), e = Math.min(e, 100), this.el = n, this.onTresholdChange = i && i.call ? i : function() {}, this.tresholdPercent = e || 1, this.currentVisibility = null, this.visibilityCalculator = ft(n, this.onVisibilityUpdate.bind(this)), this.bindScrollWatchers(), this.visibilityCalculator()
								}
								return u(t, [{
									key: "bindScrollWatchers",
									value: function() {
										for (var t = this.el.parentNode; t && (t.addEventListener("scroll", this.visibilityCalculator), t !== t.parentNode && t !== document);) t = t.parentNode
									}
								}, {
									key: "onVisibilityUpdate",
									value: function(t) {
										var n = this.currentVisibility >= this.tresholdPercent,
											e = t >= this.tresholdPercent;
										if (null === this.currentVisibility || n !== e) return this.currentVisibility = t, void this.onTresholdChange(e);
										this.currentVisibility = t
									}
								}]), t
							}();

						function ht(t) {
							return g(t) + ""
						}

						function vt(t) {
							var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : " ";
							return t && t.length ? t.map(ht).join(n) : ""
						}

						function dt(t) {
							return ht(t.x) + "," + ht(t.y)
						}

						function yt(t) {
							return t ? null == t.a || t.a >= 1 ? "rgb(" + t.r + "," + t.g + "," + t.b + ")" : "rgba(" + t.r + "," + t.g + "," + t.b + "," + t.a + ")" : "transparent"
						}

						function gt(t) {
							return t ? "url(#" + t + ")" : "none"
						}
						var pt = {
								f: null,
								i: V,
								u: function(t, n) {
									return function(e) {
										var r = n(e);
										t.setAttribute("rx", ht(r.x)), t.setAttribute("ry", ht(r.y))
									}
								}
							},
							mt = {
								f: null,
								i: function(t, n, e) {
									return 0 === t ? n : 1 === t ? e : {
										width: F(t, n.width, e.width),
										height: F(t, n.height, e.height)
									}
								},
								u: function(t, n) {
									return function(e) {
										var r = n(e);
										t.setAttribute("width", ht(r.width)), t.setAttribute("height", ht(r.height))
									}
								}
							};
						Object.freeze({
							M: 2,
							L: 2,
							Z: 0,
							H: 1,
							V: 1,
							C: 6,
							Q: 4,
							T: 2,
							S: 4,
							A: 7
						});
						var bt = {},
							wt = null;

						function At(t) {
							var n = function() {
								if (wt) return wt;
								if ("object" !== ("undefined" == typeof document ? "undefined" : e(document)) || !document.createElementNS) return {};
								var t = document.createElementNS("http://www.w3.org/2000/svg", "svg");
								return t && t.style ? (t.style.position = "absolute", t.style.opacity = "0.01", t.style.zIndex = "-9999", t.style.left = "-9999px", t.style.width = "1px", t.style.height = "1px", wt = {
									svg: t
								}) : {}
							}().svg;
							if (!n) return function(t) {
								return null
							};
							var r = document.createElementNS(n.namespaceURI, "path");
							r.setAttributeNS(null, "d", t), r.setAttributeNS(null, "fill", "none"), r.setAttributeNS(null, "stroke", "none"), n.appendChild(r);
							var i = r.getTotalLength();
							return function(t) {
								var n = r.getPointAtLength(i * t);
								return {
									x: n.x,
									y: n.y
								}
							}
						}

						function xt(t) {
							return bt[t] ? bt[t] : bt[t] = At(t)
						}

						function kt(t, n, e, r) {
							if (!t || !r) return !1;
							var i = ["M", t.x, t.y];
							if (n && e && (i.push("C"), i.push(n.x), i.push(n.y), i.push(e.x), i.push(e.y)), n ? !e : e) {
								var u = n || e;
								i.push("Q"), i.push(u.x), i.push(u.y)
							}
							return n || e || i.push("L"), i.push(r.x), i.push(r.y), i.join(" ")
						}

						function _t(t, n, e, r) {
							var i = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : 1,
								u = kt(t, n, e, r),
								o = xt(u);
							try {
								return o(i)
							} catch (t) {
								return null
							}
						}

						function St(t, n, e, r) {
							var i = 1 - r;
							return i * i * t + 2 * i * r * n + r * r * e
						}

						function Ot(t, n, e, r) {
							return 2 * (1 - r) * (n - t) + 2 * r * (e - n)
						}

						function Mt(t, n, e, r) {
							var i = arguments.length > 4 && void 0 !== arguments[4] && arguments[4],
								u = _t(t, n, null, e, r);
							return u || (u = {
								x: St(t.x, n.x, e.x, r),
								y: St(t.y, n.y, e.y, r)
							}), i && (u.a = Et(t, n, e, r)), u
						}

						function Et(t, n, e, r) {
							return Math.atan2(Ot(t.y, n.y, e.y, r), Ot(t.x, n.x, e.x, r))
						}

						function jt(t, n, e, r, i) {
							var u = i * i;
							return i * u * (r - t + 3 * (n - e)) + 3 * u * (t + e - 2 * n) + 3 * i * (n - t) + t
						}

						function Pt(t, n, e, r, i) {
							var u = 1 - i;
							return 3 * (u * u * (n - t) + 2 * u * i * (e - n) + i * i * (r - e))
						}

						function It(t, n, e, r, i) {
							var u = arguments.length > 5 && void 0 !== arguments[5] && arguments[5],
								o = _t(t, n, e, r, i);
							return o || (o = {
								x: jt(t.x, n.x, e.x, r.x, i),
								y: jt(t.y, n.y, e.y, r.y, i)
							}), u && (o.a = Bt(t, n, e, r, i)), o
						}

						function Bt(t, n, e, r, i) {
							return Math.atan2(Pt(t.y, n.y, e.y, r.y, i), Pt(t.x, n.x, e.x, r.x, i))
						}

						function Rt(t, n, e) {
							return t + (n - t) * e
						}

						function Tt(t, n, e) {
							var r = arguments.length > 3 && void 0 !== arguments[3] && arguments[3],
								i = {
									x: Rt(t.x, n.x, e),
									y: Rt(t.y, n.y, e)
								};
							return r && (i.a = Nt(t, n)), i
						}

						function Nt(t, n) {
							return Math.atan2(n.y - t.y, n.x - t.x)
						}

						function Ct(t, n, e) {
							var r = arguments.length > 3 && void 0 !== arguments[3] && arguments[3];
							if (Lt(n)) {
								if (qt(e)) return Mt(n, e.start, e, t, r)
							} else if (Lt(e)) {
								if (n.end) return Mt(n, n.end, e, t, r)
							} else {
								if (n.end) return e.start ? It(n, n.end, e.start, e, t, r) : Mt(n, n.end, e, t, r);
								if (e.start) return Mt(n, e.start, e, t, r)
							}
							return Tt(n, e, t, r)
						}

						function Ft(t, n, e) {
							var r = Ct(t, n, e, !0);
							return r.a = function(t) {
								return arguments.length > 1 && void 0 !== arguments[1] && arguments[1] ? t + Math.PI : t
							}(r.a) / m, r
						}

						function Lt(t) {
							return !t.type || "corner" === t.type
						}

						function qt(t) {
							return null != t.start && !Lt(t)
						}
						var Vt = new T;
						var Dt = {
								f: function(t) {
									return t ? t.join(" ") : ""
								},
								i: function(t, n, r) {
									if (0 === t) return n;
									if (1 === t) return r;
									var i = n.length;
									if (i !== r.length) return N(t, n, r);
									for (var u, o = new Array(i), a = 0; a < i; a++) {
										if ((u = e(n[a])) !== e(r[a])) return N(t, n, r);
										if ("number" === u) o[a] = C(t, n[a], r[a]);
										else {
											if (n[a] !== r[a]) return N(t, n, r);
											o[a] = n[a]
										}
									}
									return o
								}
							},
							zt = {
								f: null,
								i: Y,
								u: function(t, n) {
									return function(e) {
										var r = n(e);
										t.setAttribute("x1", ht(r[0])), t.setAttribute("y1", ht(r[1])), t.setAttribute("x2", ht(r[2])), t.setAttribute("y2", ht(r[3]))
									}
								}
							},
							Yt = {
								f: ht,
								i: C
							},
							Gt = {
								f: ht,
								i: L
							},
							Ut = {
								f: function(t) {
									var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : " ";
									return t && t.length > 0 && (t = t.map((function(t) {
										return g(t, 4)
									}))), vt(t, n)
								},
								i: function(t, n, e) {
									var r, i, u, o = n.length,
										a = e.length;
									if (o !== a)
										if (0 === o) n = G(o = a, 0);
										else if (0 === a) a = o, e = G(o, 0);
									else {
										var l = (u = (r = o) * (i = a) / function(t, n) {
											for (var e; n;) e = n, n = t % n, t = e;
											return t || 1
										}(r, i)) < 0 ? -u : u;
										n = U(n, Math.floor(l / o)), e = U(e, Math.floor(l / a)), o = a = l
									}
									for (var s = [], f = 0; f < o; f++) s.push(g(F(t, n[f], e[f])));
									return s
								}
							};

						function $t(t, n, e) {
							return t.map((function(t) {
								return function(t, n, e) {
									var r = t.v;
									if (!r || "g" !== r.t || r.s || !r.v || !r.r) return t;
									var i = e.getElementById(r.r),
										u = i && i.querySelectorAll("stop") || [];
									return r.s = r.v.map((function(t, n) {
										var e = u[n] && u[n].getAttribute("offset");
										return {
											c: t,
											o: e = g(parseInt(e) / 100)
										}
									})), delete r.v, t
								}(t, 0, e)
							}))
						}
						var Wt = {
							gt: "gradientTransform",
							c: {
								x: "cx",
								y: "cy"
							},
							rd: "r",
							f: {
								x: "x1",
								y: "y1"
							},
							to: {
								x: "x2",
								y: "y2"
							}
						};

						function Ht(t, n, r, i, u, o, a, l) {
							return $t(t, 0, l), n = function(t, n, e) {
									for (var r, i, u, o = t.length - 1, a = {}, l = 0; l <= o; l++)(r = t[l]).e && (r.e = n(r.e)), r.v && "g" === (i = r.v).t && i.r && (u = e.getElementById(i.r)) && (a[i.r] = {
										e: u,
										s: u.querySelectorAll("stop")
									});
									return a
								}(t, i, l),
								function(i) {
									var u = r(i, t, Qt);
									if (!u) return "none";
									if ("c" === u.t) return yt(u.v);
									if ("g" === u.t) {
										if (!n[u.r]) return gt(u.r);
										var o = n[u.r];
										return function(t, n) {
											for (var e = t.s, r = e.length; r < n.length; r++) {
												var i = e[e.length - 1].cloneNode();
												i.id = Zt(i.id), t.e.appendChild(i), e = t.s = t.e.querySelectorAll("stop")
											}
											for (var u = 0, o = e.length, a = n.length - 1; u < o; u++) e[u].setAttribute("stop-color", yt(n[Math.min(u, a)].c)), e[u].setAttribute("offset", n[Math.min(u, a)].o)
										}(o, u.s), Object.keys(Wt).forEach((function(t) {
											if (void 0 !== u[t])
												if ("object" !== e(Wt[t])) {
													var n, r = "gt" === t ? (n = u[t], Array.isArray(n) ? "matrix(" + n.join(" ") + ")" : "") : u[t],
														i = Wt[t];
													o.e.setAttribute(i, r)
												} else Object.keys(Wt[t]).forEach((function(n) {
													if (void 0 !== u[t][n]) {
														var e = u[t][n],
															r = Wt[t][n];
														o.e.setAttribute(r, e)
													}
												}))
										})), gt(u.r)
									}
									return "none"
								}
						}

						function Qt(t, e, r) {
							if (0 === t) return e;
							if (1 === t) return r;
							if (e && r) {
								var i = e.t;
								if (i === r.t) switch (e.t) {
									case "c":
										return {
											t: i, v: z(t, e.v, r.v)
										};
									case "g":
										if (e.r === r.r) {
											var u = {
												t: i,
												s: Xt(t, e.s, r.s),
												r: e.r
											};
											return e.gt && r.gt && (u.gt = Y(t, e.gt, r.gt)), e.c ? (u.c = q(t, e.c, r.c), u.rd = F(t, e.rd, r.rd)) : e.f && (u.f = q(t, e.f, r.f), u.to = q(t, e.to, r.to)), u
										}
								}
								if ("c" === e.t && "g" === r.t || "c" === r.t && "g" === e.t) {
									var o = "c" === e.t ? e : r,
										a = "g" === e.t ? n({}, e) : n({}, r),
										l = a.s.map((function(t) {
											return {
												c: o.v,
												o: t.o
											}
										}));
									return a.s = "c" === e.t ? Xt(t, l, a.s) : Xt(t, a.s, l), a
								}
							}
							return N(t, e, r)
						}

						function Xt(t, n, e) {
							if (n.length === e.length) return n.map((function(n, r) {
								return Jt(t, n, e[r])
							}));
							for (var r = Math.max(n.length, e.length), i = [], u = 0; u < r; u++) {
								var o = Jt(t, n[Math.min(u, n.length - 1)], e[Math.min(u, e.length - 1)]);
								i.push(o)
							}
							return i
						}

						function Jt(t, n, e) {
							return {
								o: L(t, n.o, e.o || 0),
								c: z(t, n.c, e.c || {})
							}
						}

						function Zt(t) {
							return t.replace(/-fill-([0-9]+)$/, (function(t, n) {
								return "-fill-" + (+n + 1)
							}))
						}
						var Kt = {
							blur: V,
							brightness: F,
							contrast: F,
							"drop-shadow": function(t, n, e) {
								return 0 === t ? n : 1 === t ? e : {
									blur: V(t, n.blur, e.blur),
									offset: q(t, n.offset, e.offset),
									color: z(t, n.color, e.color)
								}
							},
							grayscale: F,
							"hue-rotate": C,
							invert: F,
							opacity: F,
							saturate: F,
							sepia: F
						};

						function tn(t, n, e) {
							if (0 === t) return n;
							if (1 === t) return e;
							var r = n.length;
							if (r !== e.length) return N(t, n, e);
							for (var i, u = [], o = 0; o < r; o++) {
								if (n[o].type !== e[o].type) return n;
								if (!(i = Kt[n[o].type])) return N(t, n, e);
								u.push({
									type: n.type,
									value: i(t, n[o].value, e[o].value)
								})
							}
							return u
						}
						var nn = {
							blur: function(t) {
								return t ? function(n) {
									t.setAttribute("stdDeviation", dt(n))
								} : null
							},
							brightness: function(t, n, e) {
								return (t = rn(e, n)) ? function(n) {
									n = ht(n), t.map((function(t) {
										return t.setAttribute("slope", n)
									}))
								} : null
							},
							contrast: function(t, n, e) {
								return (t = rn(e, n)) ? function(n) {
									var e = ht((1 - n) / 2);
									n = ht(n), t.map((function(t) {
										t.setAttribute("slope", n), t.setAttribute("intercept", e)
									}))
								} : null
							},
							"drop-shadow": function(t, n, e) {
								var r = e.getElementById(n + "-blur");
								if (!r) return null;
								var i = e.getElementById(n + "-offset");
								if (!i) return null;
								var u = e.getElementById(n + "-flood");
								return u ? function(t) {
									r.setAttribute("stdDeviation", dt(t.blur)), i.setAttribute("dx", ht(t.offset.x)), i.setAttribute("dy", ht(t.offset.y)), u.setAttribute("flood-color", yt(t.color))
								} : null
							},
							grayscale: function(t) {
								return t ? function(n) {
									t.setAttribute("values", vt(function(t) {
										return [.2126 + .7874 * (t = 1 - t), .7152 - .7152 * t, .0722 - .0722 * t, 0, 0, .2126 - .2126 * t, .7152 + .2848 * t, .0722 - .0722 * t, 0, 0, .2126 - .2126 * t, .7152 - .7152 * t, .0722 + .9278 * t, 0, 0, 0, 0, 0, 1, 0]
									}(n)))
								} : null
							},
							"hue-rotate": function(t) {
								return t ? function(n) {
									return t.setAttribute("values", ht(n))
								} : null
							},
							invert: function(t, n, e) {
								return (t = rn(e, n)) ? function(n) {
									n = ht(n) + " " + ht(1 - n), t.map((function(t) {
										return t.setAttribute("tableValues", n)
									}))
								} : null
							},
							opacity: function(t, n, e) {
								return (t = e.getElementById(n + "-A")) ? function(n) {
									return t.setAttribute("tableValues", "0 " + ht(n))
								} : null
							},
							saturate: function(t) {
								return t ? function(n) {
									return t.setAttribute("values", ht(n))
								} : null
							},
							sepia: function(t) {
								return t ? function(n) {
									return t.setAttribute("values", vt(function(t) {
										return [.393 + .607 * (t = 1 - t), .769 - .769 * t, .189 - .189 * t, 0, 0, .349 - .349 * t, .686 + .314 * t, .168 - .168 * t, 0, 0, .272 - .272 * t, .534 - .534 * t, .131 + .869 * t, 0, 0, 0, 0, 0, 1, 0]
									}(n)))
								} : null
							}
						};
						var en = ["R", "G", "B"];

						function rn(t, n) {
							var e = en.map((function(e) {
								return t.getElementById(n + "-" + e) || null
							}));
							return -1 !== e.indexOf(null) ? null : e
						}
						var un = {
								fill: Ht,
								"fill-opacity": Gt,
								stroke: Ht,
								"stroke-opacity": Gt,
								"stroke-width": Yt,
								"stroke-dashoffset": {
									f: ht,
									i: C
								},
								"stroke-dasharray": Ut,
								opacity: Gt,
								transform: function(t, n, r, i) {
									if (!(t = function(t, n) {
											if (!t || "object" !== e(t)) return null;
											var r = !1;
											for (var i in t) t.hasOwnProperty(i) && (t[i] && t[i].length ? (t[i].forEach((function(t) {
												t.e && (t.e = n(t.e))
											})), r = !0) : delete t[i]);
											return r ? t : null
										}(t, i))) return null;
									var u = function(e, i, u) {
										var o = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null;
										return t[e] ? r(i, t[e], u) : n && n[e] ? n[e] : o
									};
									return n && n.a && t.o ? function(n) {
										var e = r(n, t.o, Ft);
										return Vt.recomposeSelf(e, u("r", n, C, 0) + e.a, u("k", n, q), u("s", n, q), u("t", n, q)).toString()
									} : function(t) {
										return Vt.recomposeSelf(u("o", t, Ct, null), u("r", t, C, 0), u("k", t, q), u("s", t, q), u("t", t, q)).toString()
									}
								},
								"#filter": function(t, n, e, r, i, u, o, a) {
									if (!n.items || !t || !t.length) return null;
									var l = function(t, n) {
										var e = (t = t.map((function(t) {
											return t && nn[t[0]] ? (n.getElementById(t[1]), nn[t[0]](n.getElementById(t[1]), t[1], n)) : null
										}))).length;
										return function(n) {
											for (var r = 0; r < e; r++) t[r] && t[r](n[r].value)
										}
									}(n.items, a);
									return l ? (t = function(t, n) {
										return t.map((function(t) {
											return t.e = n(t.e), t
										}))
									}(t, r), function(n) {
										l(e(n, t, tn))
									}) : null
								},
								"#line": zt,
								points: {
									f: vt,
									i: Y
								},
								d: Dt,
								r: Yt,
								"#size": mt,
								"#radius": pt,
								_: function(t, n) {
									if (Array.isArray(t))
										for (var e = 0; e < t.length; e++) this[t[e]] = n;
									else this[t] = n
								}
							},
							on = function(t) {
								! function(t, n) {
									if ("function" != typeof n && null !== n) throw new TypeError("Super expression must either be null or a function");
									t.prototype = Object.create(n && n.prototype, {
										constructor: {
											value: t,
											writable: !0,
											configurable: !0
										}
									}), n && l(t, n)
								}(o, t);
								var n, e, i = (n = o, e = s(), function() {
									var t, r = a(n);
									if (e) {
										var i = a(this).constructor;
										t = Reflect.construct(r, arguments, i)
									} else t = r.apply(this, arguments);
									return c(this, t)
								});

								function o() {
									return r(this, o), i.apply(this, arguments)
								}
								return u(o, null, [{
									key: "build",
									value: function(t) {
										var n = h(a(o), "build", this).call(this, t, un);
										if (!n) return null;
										var e = n.el,
											r = n.options,
											i = n.player;
										return function(t, n, e) {
											if ("click" === e.start) {
												var r = function() {
													switch (e.click) {
														case "freeze":
															return !t._running && t.reachedToEnd() && (t.offset = 0), t._running ? t.pause() : t.play();
														case "restart":
															return t.offset > 0 ? t.restart() : t.play();
														case "reverse":
															var n = !t._rollingBack && t._running,
																r = t.reachedToEnd();
															return n || r && 1 === t.fill ? (t.pause(), r && (t.offset = t.duration - 1), t._rollback()) : r ? t.restart() : t.play();
														case "none":
														default:
															return !t._running && t.offset ? t.restart() : t.play()
													}
												};
												return void n.addEventListener("click", r)
											}
											if ("hover" === e.start) return n.addEventListener("mouseenter", (function() {
												return t.reachedToEnd() ? t.restart() : t.play()
											})), void n.addEventListener("mouseleave", (function() {
												switch (e.hover) {
													case "freeze":
														return t.pause();
													case "reset":
														return t.stop();
													case "reverse":
														return t.pause(), t._rollback();
													case "none":
													default:
														return
												}
											}));
											if ("scroll" === e.start) return void new ct(n, e.scroll || 25, (function(n) {
												n ? t.reachedToEnd() ? t.restart() : t.play() : t.pause()
											}));
											t.play()
										}(i, e, r), i
									}
								}]), o
							}(st);
						return on.init(), on
					}));

					(function(s, i, o, w) {
						w[o] = w[o] || {};
						w[o][s] = w[o][s] || [];
						w[o][s].push(i);
					})('91c80d77', {
						"root": "evQrI1MWBnR1",
						"animations": [{
							"elements": {
								"evQrI1MWBnR6": {
									"d": [{
										"t": 12166.666666666668,
										"v": ["M", 749.139041, 638.950293, "C", 746.558872, 652.818705, 744.546554, 654.631958, 743.874482, 666.841256, "C", 743.20241, 679.050554, 748.578982, 687.11541, 757.987981, 687.451446, "C", 767.39698, 687.787482, 771.653433, 676.586292, 770.645326, 665.497114, "C", 769.637219, 654.407936, 767.836518, 652.032454, 764.820707, 638.838281, "C", 763.924612, 634.917865, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 750.035136, 634.133781, 749.139041, 638.950293, "Z"]
									}, {
										"t": 12266.666666666668,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 13750,
										"v": ["M", 749.139041, 638.950293, "C", 746.558872, 652.818705, 744.546554, 654.631958, 743.874482, 666.841256, "C", 743.20241, 679.050554, 748.578982, 687.11541, 757.987981, 687.451446, "C", 767.39698, 687.787482, 771.653433, 676.586292, 770.645326, 665.497114, "C", 769.637219, 654.407936, 767.836518, 652.032454, 764.820707, 638.838281, "C", 763.924612, 634.917865, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 750.035136, 634.133781, 749.139041, 638.950293, "Z"]
									}, {
										"t": 13850,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 13891.666666666668,
										"v": ["M", 748.542956, 646.055662, "C", 746.793956, 649.658519, 744.546554, 654.631958, 743.874482, 666.841256, "C", 743.20241, 679.050554, 748.578982, 687.11541, 757.987981, 687.451446, "C", 767.39698, 687.787482, 771.653433, 676.586292, 770.645326, 665.497114, "C", 769.637219, 654.407936, 767.365965, 650.82459, 764.460248, 644.831255, "C", 763.145393, 642.119234, 760.247016, 639.044779, 756.683149, 638.888112, "C", 753.119282, 638.731445, 750.682471, 641.648363, 748.542956, 646.055662, "Z"]
									}, {
										"t": 13983.333333333334,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 15583.333333333334,
										"v": ["M", 748.992444, 638.475352, "C", 746.412275, 652.343764, 745.113882, 653.894907, 744.44181, 666.104205, "C", 743.769738, 678.313503, 749.480013, 687.71972, 757.931191, 687.557197, "C", 766.382369, 687.394674, 770.965975, 675.080589, 769.957868, 663.991411, "C", 768.949761, 652.902233, 767.836518, 652.032454, 764.820707, 638.838281, "C", 763.924612, 634.917865, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 749.888539, 633.65884, 748.992444, 638.475352, "Z"]
									}, {
										"t": 15675,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 17916.666666666668,
										"v": ["M", 748.992444, 638.475352, "C", 746.732857, 650.989597, 745.757721, 654.565096, 744.945108, 665.941682, "C", 744.132495, 677.318268, 749.495743, 687.394674, 757.946921, 687.232151, "C", 766.398099, 687.069628, 770.298643, 674.555384, 769.48603, 664.316456, "C", 768.673417, 654.077528, 767.626161, 652.319616, 764.61035, 639.125443, "C", 763.714255, 635.205027, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 749.862966, 633.654152, 748.992444, 638.475352, "Z"]
									}, {
										"t": 18008.333333333336,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 20583.333333333336,
										"v": ["M", 749.495743, 638.637875, "C", 747.236156, 651.15212, 746.245289, 654.890142, 745.432676, 666.266728, "C", 744.620063, 677.643314, 749.495743, 687.394674, 757.946921, 687.232151, "C", 766.398099, 687.069628, 769.48603, 674.717907, 768.673417, 664.478979, "C", 767.860804, 654.240051, 766.723145, 651.802211, 764.285305, 639.613011, "C", 763.496619, 635.669583, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 750.366265, 633.816675, 749.495743, 638.637875, "Z"]
									}, {
										"t": 20675,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 23416.666666666668,
										"v": ["M", 749.658265, 638.637875, "C", 747.398678, 651.15212, 746.245289, 654.890142, 745.432676, 666.266728, "C", 744.620063, 677.643314, 749.495743, 687.394674, 757.946921, 687.232151, "C", 766.398099, 687.069628, 769.323507, 674.717907, 768.510894, 664.478979, "C", 767.698281, 654.240051, 766.560622, 651.477166, 764.122782, 639.287966, "C", 763.334096, 635.344538, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 750.528787, 633.816675, 749.658265, 638.637875, "Z"]
									}, {
										"t": 23508.333333333336,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}, {
										"t": 26250,
										"v": ["M", 749.658265, 638.637875, "C", 747.398678, 651.15212, 746.245289, 654.890142, 745.432676, 666.266728, "C", 744.620063, 677.643314, 749.495743, 687.394674, 757.946921, 687.232151, "C", 766.398099, 687.069628, 769.323507, 674.717907, 768.510894, 664.478979, "C", 767.698281, 654.240051, 766.560622, 651.477166, 764.122782, 639.287966, "C", 763.334096, 635.344538, 761.094056, 630.988279, 757.091886, 630.997448, "C", 753.089716, 631.006617, 750.528787, 633.816675, 749.658265, 638.637875, "Z"]
									}, {
										"t": 26341.666666666668,
										"v": ["M", 749.696525, 657.576647, "C", 747.209665, 660.622255, 744.585418, 663.899934, 744.149834, 672.263147, "C", 743.71425, 680.62636, 747.430042, 688.030364, 756.909909, 688.081318, "C", 766.389776, 688.132272, 769.829849, 679.907283, 769.169769, 671.683981, "C", 768.509689, 663.460679, 766.362692, 659.844153, 764.304782, 657.204852, "C", 763.273788, 655.882586, 761.287679, 653.781032, 757.349356, 653.665199, "C", 753.411033, 653.549366, 751.117626, 655.836253, 749.696525, 657.576647, "Z"]
									}],
									"transform": {
										"data": {
											"t": {
												"x": -756.752261,
												"y": -630.775436
											}
										},
										"keys": {
											"o": [{
												"t": 12166.666666666668,
												"v": {
													"x": 753.664775,
													"y": 704.010737,
													"type": "corner"
												}
											}, {
												"t": 12266.666666666668,
												"v": {
													"x": 754.04408,
													"y": 853.328687,
													"type": "corner"
												}
											}, {
												"t": 13750,
												"v": {
													"x": 757.09489,
													"y": 714.765082,
													"type": "corner"
												}
											}, {
												"t": 13850,
												"v": {
													"x": 757.09,
													"y": 853.328687,
													"type": "corner"
												}
											}, {
												"t": 13891.666666666668,
												"v": {
													"x": 758.216438,
													"y": 653.252126,
													"type": "corner"
												}
											}, {
												"t": 13983.333333333334,
												"v": {
													"x": 758.22,
													"y": 854.087298,
													"type": "corner"
												}
											}, {
												"t": 15583.333333333334,
												"v": {
													"x": 760.790583,
													"y": 722.733857,
													"type": "corner"
												}
											}, {
												"t": 15675,
												"v": {
													"x": 760.79,
													"y": 854.087298,
													"type": "corner"
												}
											}, {
												"t": 17916.666666666668,
												"v": {
													"x": 764.025306,
													"y": 724.846652,
													"type": "corner"
												}
											}, {
												"t": 18008.333333333336,
												"v": {
													"x": 764.03,
													"y": 854.087298,
													"type": "corner"
												}
											}, {
												"t": 20583.333333333336,
												"v": {
													"x": 765.000442,
													"y": 723.54647,
													"type": "corner"
												}
											}, {
												"t": 20675,
												"v": {
													"x": 765,
													"y": 854.087298,
													"type": "corner"
												}
											}, {
												"t": 23416.666666666668,
												"v": {
													"x": 765.000442,
													"y": 723.54647,
													"type": "corner"
												}
											}, {
												"t": 23508.333333333336,
												"v": {
													"x": 765,
													"y": 854.087298,
													"type": "corner"
												}
											}, {
												"t": 26250,
												"v": {
													"x": 764.837919,
													"y": 723.221425,
													"type": "corner"
												}
											}, {
												"t": 26341.666666666668,
												"v": {
													"x": 764.84,
													"y": 854.087298,
													"type": "corner"
												}
											}]
										}
									},
									"opacity": [{
										"t": 12158.333333333334,
										"v": 0
									}, {
										"t": 12166.666666666668,
										"v": 1
									}, {
										"t": 12258.333333333334,
										"v": 1
									}, {
										"t": 12266.666666666668,
										"v": 0
									}, {
										"t": 13741.666666666668,
										"v": 0
									}, {
										"t": 13750,
										"v": 1
									}, {
										"t": 13841.666666666668,
										"v": 1
									}, {
										"t": 13850,
										"v": 0
									}, {
										"t": 13891.666666666668,
										"v": 0
									}, {
										"t": 13900,
										"v": 1
									}, {
										"t": 13975,
										"v": 1
									}, {
										"t": 13983.333333333334,
										"v": 0
									}, {
										"t": 15575,
										"v": 0
									}, {
										"t": 15583.333333333334,
										"v": 1
									}, {
										"t": 15666.666666666668,
										"v": 1
									}, {
										"t": 15675,
										"v": 0
									}, {
										"t": 17908.333333333336,
										"v": 0
									}, {
										"t": 17916.666666666668,
										"v": 1
									}, {
										"t": 18000,
										"v": 1
									}, {
										"t": 18008.333333333336,
										"v": 0
									}, {
										"t": 20575,
										"v": 0
									}, {
										"t": 20583.333333333336,
										"v": 1
									}, {
										"t": 20666.666666666668,
										"v": 1
									}, {
										"t": 20675,
										"v": 0
									}, {
										"t": 23408.333333333336,
										"v": 0
									}, {
										"t": 23416.666666666668,
										"v": 1
									}, {
										"t": 23500,
										"v": 1
									}, {
										"t": 23508.333333333336,
										"v": 0
									}, {
										"t": 26241.666666666668,
										"v": 0
									}, {
										"t": 26250,
										"v": 1
									}, {
										"t": 26333.333333333336,
										"v": 1
									}, {
										"t": 26341.666666666668,
										"v": 0
									}]
								},
								"evQrI1MWBnR7": {
									"transform": {
										"data": {
											"t": {
												"x": -486.734974,
												"y": -499.653938
											}
										},
										"keys": {
											"o": [{
												"t": 0,
												"v": {
													"x": 421.281317,
													"y": 520.678143,
													"type": "corner"
												},
												"e": [0, 0, 0.62, 0.88]
											}, {
												"t": 10000,
												"v": {
													"x": 487.924138,
													"y": 502.209486,
													"type": "corner"
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 20000,
												"v": {
													"x": 489.078495,
													"y": 501.88958,
													"type": "corner"
												}
											}],
											"s": [{
												"t": 0,
												"v": {
													"x": 0.406646,
													"y": 0.637111
												},
												"e": [0, 0, 0.62, 0.88]
											}, {
												"t": 10000,
												"v": {
													"x": 0.989897,
													"y": 1.301553
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 20000,
												"v": {
													"x": 1.053485,
													"y": 1.383289
												}
											}]
										}
									}
								},
								"evQrI1MWBnR8": {
									"d": [{
										"t": 0,
										"v": ["M", 785.93, 565.665423, "C", 831.896401, 564.28, 895.93, 549.81, 909.34, 539.97, "C", 913.562626, 535.579134, 914.274448, 526.945022, 909.34, 523.86484, "C", 886.634903, 509.691861, 783.087242, 508.983826, 752.98, 508.944211, "C", 700.76, 508.874211, 727.69, 497.944211, 630.36, 497.944211, "C", 630.36, 497.944211, 420.7, 491.664211, 420.7, 491.664211, "C", 395.7, 493.104211, 271.77, 496.384211, 234.19, 496.384211, "C", 196.84, 496.384211, 235.82, 517.124211, 180.67, 518.384211, "C", 100.069132, 519.521821, 87.807247, 520.552376, 68.950655, 529.785318, "C", 64.201939, 532.110479, 62.661472, 538.72324, 64.13, 544.59, "C", 73.225435, 564.61, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 214.98, 566.1, 252.45, 564.61, "C", 290.14, 563.11, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 625.842171, 575.777161, 672.85, 572.56, "C", 719.857829, 569.342839, 739.963599, 567.050846, 785.93, 565.665423, "Z"]
									}, {
										"t": 10000,
										"v": ["M", 820.980055, 558.666539, "C", 866.946456, 557.281116, 951.916332, 550.669085, 965.326332, 540.829085, "C", 977.533692, 534.887311, 970.941883, 528.693328, 962.590479, 524.065339, "C", 939.17929, 511.091865, 783.087242, 508.983826, 752.98, 508.944211, "C", 700.76, 508.874211, 707.020833, 499.005096, 630.36, 497.944211, "C", 565.049331, 497.040397, 412.86679, 487.942302, 412.86679, 487.942302, "C", 387.830276, 488.438954, 273.290344, 493.214199, 234.19, 496.384211, "C", 196.962149, 499.402413, 200.959833, 508.239918, 161.3559, 510.165398, "C", 80.842106, 514.07985, 52.41385, 516.797144, 36.698579, 526.573213, "C", 32.208974, 529.366082, 29.102419, 531.434603, 30.570947, 537.301363, "C", 39.666382, 557.321363, 162.618116, 549.901989, 188.438116, 552.521989, "C", 214.258116, 555.141989, 227.697488, 566.62065, 265.167488, 565.13065, "C", 302.857488, 563.63065, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 675.386026, 578.646127, 720.60235, 574.310966, "C", 765.818674, 569.975805, 775.013654, 560.051962, 820.980055, 558.666539, "Z"]
									}, {
										"t": 20000,
										"v": ["M", 841.547516, 560.761758, "C", 887.513917, 559.376335, 965.953525, 550.00917, 979.363525, 540.16917, "C", 991.570885, 534.227396, 984.594245, 527.128438, 975.457594, 523.19291, "C", 942.809514, 509.13005, 783.087242, 508.983826, 752.98, 508.944211, "C", 700.76, 508.874211, 702.220363, 499.056445, 630.36, 497.944211, "C", 566.753268, 496.959724, 418.665749, 485.70361, 418.665749, 485.70361, "C", 393.616689, 486.414991, 272.905302, 494.210387, 234.19, 496.384211, "C", 198.230147, 498.403319, 182.528962, 501.603009, 129.048671, 504.390763, "C", 44.95149, 508.774476, 26.685746, 517.136268, 7.829154, 526.36921, "C", 3.080438, 528.694371, 1.539971, 535.307132, 3.008499, 541.173892, "C", 12.103934, 561.193892, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 220.057318, 564.861543, 252.45, 564.61, "C", 290.1687, 564.317098, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 684.402472, 575.443789, 731.410301, 572.226628, "C", 778.41813, 569.009467, 795.581115, 562.147181, 841.547516, 560.761758, "Z"]
									}]
								},
								"evQrI1MWBnR9": {
									"d": [{
										"t": 10000,
										"v": ["M", 658.683436, 584.943616, "C", 662.694819, 587.635033, 684.408911, 597.269141, 688.76883, 597.631728, "C", 693.127974, 597.994481, 703.121814, 597.234923, 708.960463, 596.962848, "C", 714.904581, 596.685858, 725.264671, 596.635155, 732.03449, 595.709281, "C", 738.804309, 594.783407, 747.588696, 593.840342, 757.279074, 590.152105, "C", 767.175192, 586.385562, 770.034249, 584.960992, 775.280392, 583.21806, "C", 780.526535, 581.475128, 787.106623, 580.313075, 791.55105, 579.844806, "C", 798.206616, 579.143569, 811.644666, 578.603041, 816.212406, 577.795107, "C", 826.911302, 575.902705, 840.857353, 566.952475, 844.171363, 563.726432],
										"e": [0.49, 0.08, 0.995, 0.995]
									}, {
										"t": 11583.333333333334,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.514516, 595.181349, 694.983991, 595.345492, "C", 704.590253, 595.685868, 714.962253, 594.883926, 722.676155, 598.684546, "C", 728.766435, 601.695256, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 780.926826, 597.331147, 787.272156, 589.197319, "C", 793.149797, 581.663003, 802.673288, 578.660432, 809.546601, 577.957651, "C", 830.363537, 575.829165, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 12016.666666666668,
										"v": ["M", 670.402734, 573.596994, "C", 670.402734, 573.596994, 704.998311, 595.211977, 721.908822, 594.299455, "C", 736.352572, 593.520044, 744.973866, 600.362999, 746.467653, 617.93544, "C", 748.324238, 639.775727, 743.690341, 666.351083, 744.082045, 674.674292, "C", 744.473749, 682.997501, 746.769525, 690.481644, 753.152295, 690.284052, "C", 759.535065, 690.08646, 761.375745, 682.138784, 761.550677, 673.883925, "C", 761.72561, 665.629066, 757.087637, 643.931256, 759.632529, 615.949958, "C", 760.799372, 603.120421, 764.537212, 583.972553, 782.823789, 580.699024, "C", 797.165356, 578.131702, 831.914487, 561.000479, 831.914497, 561.00048]
									}, {
										"t": 12166.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.684315, 594.244523, 724.809426, 593.903076, "C", 742.683224, 593.546701, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 754.989269, 661.048052, 755.612192, 634.531928, "C", 756.256797, 607.092865, 756.454945, 585.69505, 788.381531, 579.412675, "C", 807.958488, 575.560406, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 12175,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.606315, 593.565492, 725.896252, 593.82105, "C", 742.117922, 594.035959, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 755.355079, 645.614906, 755.612192, 634.531928, "C", 756.250712, 607.008271, 756.329927, 585.582333, 789.263229, 579.448247, "C", 801.533108, 577.162886, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 12300,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.484802, 594.693859, 694.954277, 594.858002, "C", 704.560539, 595.198378, 714.962253, 594.883926, 722.676155, 598.684546, "C", 728.766435, 601.695256, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 780.638697, 597.097926, 787.272156, 589.197319, "C", 793.485433, 581.797159, 802.437323, 578.438108, 809.607188, 577.726299, "C", 824.137838, 576.283727, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 13750,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 706.457539, 592.553522, 723.58265, 592.212075, "C", 741.456448, 591.8557, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 753.915945, 661.001069, 755.612192, 634.531928, "C", 757.175268, 610.140861, 757.120627, 589.455089, 786.243237, 579.907801, "C", 808.479674, 572.618012, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 13758.333333333334,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 705.387688, 591.881356, 724.677625, 592.136914, "C", 740.899295, 592.351823, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 755.054328, 645.60384, 755.612192, 634.531928, "C", 756.836005, 610.242943, 757.271696, 589.45547, 786.680673, 579.942559, "C", 797.473721, 576.451336, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 13983.333333333334,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.336042, 592.782789, 694.805517, 592.946932, "C", 704.411779, 593.287308, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.198773, 596.962579, 784.544103, 588.828751, "C", 790.421744, 581.294435, 801.026279, 578.225917, 808.102915, 577.479506, "C", 823.664169, 575.838176, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 15583.333333333334,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 706.285745, 591.251621, 723.410856, 590.910174, "C", 741.284654, 590.553799, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 754.02561, 661.007872, 755.612192, 634.531928, "C", 757.210573, 607.859097, 758.565289, 587.909933, 786.798809, 580.047906, "C", 809.34196, 573.770444, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 15591.666666666668,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 703.981082, 590.649356, 723.271019, 590.904914, "C", 739.492689, 591.119823, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 754.896291, 645.594748, 755.612192, 634.531928, "C", 757.348434, 607.701785, 758.621766, 587.821188, 787.296252, 580.048061, "C", 808.277936, 574.360311, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 15816.666666666668,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.603367, 591.606202, 694.072842, 591.770345, "C", 703.679104, 592.110721, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.198773, 596.962579, 784.544103, 588.828751, "C", 790.421744, 581.294435, 796.689474, 578.771774, 808.310287, 577.63005, "C", 822.842399, 576.202296, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 17916.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.946671, 590.949429, 725.071782, 590.607982, "C", 742.94558, 590.251607, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 754.654461, 661.038071, 755.612192, 634.531928, "C", 756.603411, 607.098959, 756.712975, 587.240721, 796.815104, 579.578034, "C", 815.884964, 575.934178, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 17925,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 705.768889, 590.607212, 725.060516, 590.607211, "C", 742.593146, 590.60721, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 755.220192, 645.610953, 755.612192, 634.531928, "C", 756.582195, 607.116921, 756.708398, 587.347906, 797.12897, 579.615701, "C", 816.753197, 575.861708, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 18150,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.55366, 591.443591, 694.023135, 591.607734, "C", 703.629397, 591.94811, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.198773, 596.962579, 784.544103, 588.828751, "C", 790.421744, 581.294435, 798.147724, 579.502671, 809.768537, 578.360947, "C", 824.300649, 576.933193, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 20583.333333333336,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 708.050893, 590.866923, 725.176004, 590.525476, "C", 743.049802, 590.169101, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 755.09704, 661.050365, 755.612192, 634.531928, "C", 756.141646, 607.277255, 756.270679, 587.411143, 806.853244, 579.5851, "C", 829.978949, 576.007133, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 20591.666666666668,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 705.745394, 590.29622, 725.035331, 590.551778, "C", 741.257001, 590.766687, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 755.343902, 645.614637, 755.612192, 634.531928, "C", 756.271929, 607.279065, 756.400987, 587.412316, 809.188098, 579.826839, "C", 820.41642, 578.213336, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 20816.666666666668,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.86842, 591.503453, 694.337895, 591.667596, "C", 703.944157, 592.007972, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.198773, 596.962579, 784.544103, 588.828751, "C", 790.421744, 581.294435, 797.557807, 580.810378, 809.17862, 579.668654, "C", 823.710732, 578.2409, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 23416.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.995714, 590.858158, 725.120825, 590.516711, "C", 742.994623, 590.160336, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 754.996388, 661.048217, 755.612192, 634.531928, "C", 756.239357, 607.526454, 756.260303, 587.437783, 790.241478, 582.302429, "C", 813.379609, 578.805714, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 23425,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 705.830888, 590.261153, 725.120825, 590.516711, "C", 741.342495, 590.73162, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 754.600289, 644.672455, 754.807367, 633.58843, "C", 755.316209, 606.352175, 756.375809, 587.400992, 790.463205, 582.234957, "C", 801.67879, 580.535205, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 23650,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.759271, 591.630678, 694.229825, 591.696571, "C", 704.757931, 591.762826, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.198773, 596.962579, 784.544103, 588.828751, "C", 790.421744, 581.294435, 797.423448, 580.889324, 809.044261, 579.7476, "C", 823.576373, 578.319846, 837.202886, 564.050904, 840.114851, 557.173249]
									}, {
										"t": 26250,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.846293, 590.936771, 724.971404, 590.595324, "C", 742.845202, 590.238949, 747.432283, 611.984288, 749.345593, 638.54614, "C", 750.903964, 660.180495, 745.447997, 674.648575, 744.883107, 683.498514, "C", 744.318217, 692.348453, 747.317192, 699.350144, 753.402398, 699.350143, "C", 759.487604, 699.350142, 762.20927, 691.320562, 761.313169, 682.552149, "C", 760.417068, 673.783736, 755.060154, 661.049621, 755.612192, 634.531928, "C", 756.184676, 607.03207, 756.296352, 587.518916, 790.245017, 582.356711, "C", 813.379939, 578.838834, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 26258.333333333336,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 705.883189, 590.294146, 725.173126, 590.549704, "C", 741.394796, 590.764613, 747.510652, 611.25408, 749.256569, 637.827463, "C", 749.873553, 647.218146, 749.97903, 663.106337, 749.846418, 668.672076, "C", 749.713806, 674.237815, 750.072457, 680.362792, 752.326841, 680.5174, "C", 754.581225, 680.672008, 755.018237, 676.71147, 755.018236, 668.826681, "C", 755.018235, 660.941892, 755.378215, 645.615417, 755.612192, 634.531928, "C", 756.191436, 607.093143, 756.292293, 587.349305, 790.292267, 582.265337, "C", 801.511198, 580.587786, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.225, 0.94]
									}, {
										"t": 26483.333333333336,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.796344, 591.629781, 694.266898, 591.695674, "C", 704.795004, 591.761929, 714.676308, 592.031152, 722.39021, 595.831772, "C", 728.48049, 598.842482, 733.450181, 607.40324, 736.552235, 614.234048, "C", 739.654289, 621.064856, 744.639234, 630.502459, 754.966089, 630.794414, "C", 765.292943, 631.086369, 769.976668, 619.523538, 773.186196, 612.72375, "C", 776.395724, 605.923962, 778.85469, 597.434153, 784.544103, 588.828751, "C", 790.993272, 581.777454, 797.547997, 580.790669, 809.16881, 579.648945, "C", 823.700922, 578.221191, 837.202886, 564.050904, 840.114851, 557.173249],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 33333.333333333336,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 683.796344, 591.629781, 694.266898, 591.695674, "C", 704.795004, 591.761929, 706.798892, 591.695844, 711.973701, 591.832536, "C", 717.50316, 591.978596, 721.058273, 591.76561, 727.614171, 593.001017, "C", 734.170069, 594.236424, 743.854762, 596.744867, 753.839605, 596.214336, "C", 763.824448, 595.683805, 773.271705, 590.517999, 776.905349, 588.03498, "C", 780.538993, 585.551961, 786.462684, 583.640787, 791.597912, 582.338645, "C", 796.279033, 581.151651, 797.547997, 580.790669, 809.16881, 579.648945, "C", 823.700922, 578.221191, 837.202886, 564.050904, 840.114851, 557.173249]
									}],
									"transform": {
										"data": {
											"o": {
												"x": 745.0771,
												"y": 535.406166,
												"type": "corner"
											},
											"t": {
												"x": -750.246898,
												"y": -550.088684
											}
										},
										"keys": {
											"s": [{
												"t": 10000,
												"v": {
													"x": 1.763569,
													"y": 1
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 16125,
												"v": {
													"x": 1.509723,
													"y": 1.127826
												}
											}, {
												"t": 21016.666666666668,
												"v": {
													"x": 1.344558,
													"y": 1.107589
												}
											}]
										}
									},
									"opacity": [{
										"t": 9583.333333333334,
										"v": 0
									}, {
										"t": 10000,
										"v": 1
									}]
								},
								"evQrI1MWBnR10": {
									"d": [{
										"t": 0,
										"v": ["M", 785.93, 565.665423, "C", 831.896401, 564.28, 895.93, 549.81, 909.34, 539.97, "C", 929.67, 518.83, 790.98, 516.61, 752.98, 516.56, "C", 700.76, 516.49, 727.69, 505.56, 630.36, 505.56, "C", 630.36, 505.56, 420.7, 499.28, 420.7, 499.28, "C", 395.7, 500.72, 271.77, 504, 234.19, 504, "C", 196.84, 504, 235.82, 524.74, 180.67, 526, "C", 126, 527.31, 68.89, 525.8, 64.13, 544.59, "C", 59.37, 563.38, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 214.98, 566.1, 252.45, 564.61, "C", 290.14, 563.11, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 625.842171, 575.777161, 672.85, 572.56, "C", 719.857829, 569.342839, 739.963599, 567.050846, 785.93, 565.665423, "Z"]
									}, {
										"t": 10000,
										"v": ["M", 821.33249, 558.382569, "C", 867.298891, 556.997146, 953.99203, 551.087567, 967.40203, 541.247567, "C", 987.73203, 520.107567, 790.98, 516.61, 752.98, 516.56, "C", 700.76, 516.49, 709.22677, 507.048436, 630.36, 505.56, "C", 565.029012, 504.327022, 412.788023, 495.407077, 412.788023, 495.407077, "C", 387.747062, 495.561543, 271.790398, 501.357301, 234.19, 504, "C", 196.931911, 506.61864, 201.998691, 515.1888, 161.161667, 517.447718, "C", 106.559447, 520.468064, 35.421455, 522.126553, 31.776267, 537.96463, "C", 28.131079, 553.802707, 162.741879, 549.698798, 188.561879, 552.318798, "C", 214.381879, 554.938798, 227.825368, 566.641775, 265.295368, 565.151775, "C", 302.985368, 563.651775, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 671.550124, 579.18495, 721.082519, 574.382013, "C", 770.614914, 569.579076, 775.366089, 559.767992, 821.33249, 558.382569, "Z"]
									}, {
										"t": 20000,
										"v": ["M", 842.106814, 560.562799, "C", 888.073215, 559.177376, 966.657649, 550.017251, 980.067649, 540.177251, "C", 1000.397649, 519.037251, 790.98, 516.61, 752.98, 516.56, "C", 700.76, 516.49, 693.041619, 506.237187, 630.36, 505.56, "C", 566.739003, 504.872664, 418.645292, 493.077552, 418.645292, 493.077552, "C", 392.898928, 493.265188, 272.341094, 502.765414, 234.19, 504, "C", 197.331411, 505.19276, 181.782277, 508.376606, 128.529541, 511.438802, "C", 74.188123, 514.563601, 7.153872, 522.245287, 2.393872, 541.035287, "C", -2.366128, 559.825287, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 214.950607, 564.738252, 252.45, 564.61, "C", 290.164051, 564.481014, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 684.991366, 575.430258, 731.999195, 572.213097, "C", 779.007024, 568.995936, 796.140413, 561.948222, 842.106814, 560.562799, "Z"]
									}]
								},
								"evQrI1MWBnR11": {
									"d": [{
										"t": 10000,
										"v": ["M", 658.683436, 584.943616, "C", 658.683436, 584.943616, 684.177862, 589.84364, 688.537781, 590.206227, "C", 692.896925, 590.56898, 702.890765, 589.809422, 708.729414, 589.537347, "C", 714.673532, 589.260357, 725.033622, 589.209654, 731.803441, 588.28378, "C", 738.57326, 587.357906, 747.357647, 586.414841, 757.048025, 582.726604, "C", 766.944143, 578.960061, 769.8032, 577.535491, 775.049343, 575.792559, "C", 780.295486, 574.049627, 786.875574, 572.887574, 791.320001, 572.419305, "C", 797.975567, 571.718068, 811.413617, 571.17754, 815.981357, 570.369606, "C", 826.680253, 568.477204, 843.034239, 564.527013, 844.171363, 563.726432],
										"e": [0.49, 0.08, 0.995, 0.995]
									}, {
										"t": 11583.333333333334,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 744.513606, 623.603014, 754.840461, 623.894969, "C", 765.167315, 624.186924, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 780.801198, 590.431702, 787.146528, 582.297874, "C", 793.024169, 574.763558, 802.54766, 571.760987, 809.420973, 571.058206, "C", 830.237909, 568.92972, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 12016.666666666668,
										"v": ["M", 670.402734, 573.596994, "C", 670.402734, 573.596994, 705.090792, 584.469104, 723.090526, 585.477795, "C", 737.532629, 586.287119, 747.991781, 600.362999, 749.485568, 617.93544, "C", 751.342153, 639.775727, 747.544413, 663.756927, 747.351476, 671.697882, "C", 747.158539, 679.638837, 748.130235, 685.173833, 753.109841, 685.240795, "C", 758.089447, 685.307757, 758.594255, 678.182262, 758.401314, 671.148847, "C", 758.208373, 664.115432, 754.069722, 643.931256, 756.614614, 615.949958, "C", 757.781457, 603.120421, 760.515774, 579.744598, 778.669001, 575.35695, "C", 792.972033, 571.899897, 812.981281, 569.678203, 827.722858, 559.516235]
									}, {
										"t": 12166.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.720921, 586.6315, 724.846032, 586.290053, "C", 742.71983, 585.933678, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.566525, 660.341841, 753.189448, 633.825717, "C", 753.834053, 606.386654, 756.454945, 578.63294, 788.381531, 572.350565, "C", 807.958488, 568.498296, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 12175,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.618161, 587.419767, 725.908098, 587.675325, "C", 742.129768, 587.890234, 748.9768, 606.539454, 750.722717, 633.112837, "C", 751.339701, 642.50352, 751.796436, 663.106337, 751.663824, 668.672076, "C", 751.531212, 674.237815, 751.347971, 678.377376, 752.326841, 678.399355, "C", 753.305711, 678.421334, 753.200831, 676.71147, 753.20083, 668.826681, "C", 753.200829, 660.941892, 753.645758, 642.174235, 753.902871, 631.091257, "C", 754.541391, 603.5676, 756.329927, 579.934213, 789.263229, 573.800127, "C", 801.533108, 571.514766, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 12300,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 744.513606, 623.603014, 754.840461, 623.894969, "C", 765.167315, 624.186924, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 780.335111, 590.045582, 787.146528, 582.297874, "C", 792.305073, 576.43024, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 13750,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.720921, 586.6315, 724.846032, 586.290053, "C", 742.71983, 585.933678, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.566525, 660.341841, 753.189448, 633.825717, "C", 753.834053, 606.386654, 756.454945, 578.63294, 788.381531, 572.350565, "C", 807.958488, 568.498296, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 13758.333333333334,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.618161, 587.419767, 725.908098, 587.675325, "C", 742.129768, 587.890234, 748.9768, 606.539454, 750.722717, 633.112837, "C", 751.339701, 642.50352, 751.796436, 663.106337, 751.663824, 668.672076, "C", 751.531212, 674.237815, 751.347971, 678.377376, 752.326841, 678.399355, "C", 753.305711, 678.421334, 753.200831, 676.71147, 753.20083, 668.826681, "C", 753.200829, 660.941892, 753.645758, 642.174235, 753.902871, 631.091257, "C", 754.541391, 603.5676, 756.329927, 579.934213, 789.263229, 573.800127, "C", 801.533108, 571.514766, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 13983.333333333334,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 744.513606, 623.603014, 754.840461, 623.894969, "C", 765.167315, 624.186924, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 780.335111, 590.045582, 787.146528, 582.297874, "C", 792.305073, 576.43024, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 15583.333333333334,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.720921, 586.6315, 724.846032, 586.290053, "C", 742.71983, 585.933678, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.566525, 660.341841, 753.189448, 633.825717, "C", 753.834053, 606.386654, 756.454945, 578.63294, 788.381531, 572.350565, "C", 807.958488, 568.498296, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 15591.666666666668,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.618161, 587.419767, 725.908098, 587.675325, "C", 742.129768, 587.890234, 748.9768, 606.539454, 750.722717, 633.112837, "C", 751.339701, 642.50352, 751.796436, 663.106337, 751.663824, 668.672076, "C", 751.531212, 674.237815, 750.69072, 678.588708, 752.455472, 678.588705, "C", 754.220224, 678.588702, 753.200831, 676.71147, 753.20083, 668.826681, "C", 753.200829, 660.941892, 753.645758, 642.174235, 753.902871, 631.091257, "C", 754.541391, 603.5676, 756.329927, 579.934213, 789.263229, 573.800127, "C", 801.533108, 571.514766, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 15816.666666666668,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 742.608747, 625.742814, 754.654585, 626.099108, "C", 766.700423, 626.455402, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 780.335111, 590.045582, 787.146528, 582.297874, "C", 792.305073, 576.43024, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 17916.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.772164, 584.922953, 724.846032, 586.290053, "C", 745.459881, 587.940598, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.566525, 660.341841, 753.189448, 633.825717, "C", 753.834053, 606.386654, 756.454945, 578.63294, 788.381531, 572.350565, "C", 807.958488, 568.498296, 827.265812, 566.627348, 827.614614, 566.220498],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 17925,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.458524, 585.097572, 725.690554, 586.612811, "C", 742.533935, 587.939855, 748.9768, 605.24387, 750.722717, 631.817253, "C", 751.339701, 641.207936, 751.796436, 661.810753, 751.663824, 667.376492, "C", 751.531212, 672.942231, 750.69072, 677.293124, 752.455472, 677.293121, "C", 754.220224, 677.293118, 753.200831, 675.415886, 753.20083, 667.531097, "C", 753.200829, 659.646308, 753.645758, 640.878651, 753.902871, 629.795673, "C", 754.541391, 602.272016, 756.329927, 579.934213, 789.263229, 573.800127, "C", 801.533108, 571.514766, 827.280247, 567.811427, 827.622061, 566.217444],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 18150,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 742.608747, 625.742814, 754.654585, 626.099108, "C", 766.700423, 626.455402, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 780.335111, 590.045582, 787.146528, 582.297874, "C", 792.305073, 576.43024, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 20583.333333333336,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.772164, 584.922953, 724.846032, 586.290053, "C", 745.459881, 587.940598, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.606208, 659.20036, 753.229131, 632.684236, "C", 753.873736, 605.245173, 756.763711, 581.652194, 788.690297, 575.369819, "C", 808.267254, 571.51755, 827.574578, 569.646602, 827.92338, 569.239752],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 20591.666666666668,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.458524, 585.097572, 725.690554, 586.612811, "C", 742.533935, 587.939855, 748.9768, 605.24387, 750.722717, 631.817253, "C", 751.339701, 641.207936, 751.796436, 661.810753, 751.663824, 667.376492, "C", 751.531212, 672.942231, 750.69072, 677.293124, 752.455472, 677.293121, "C", 754.220224, 677.293118, 753.200831, 675.415886, 753.20083, 667.531097, "C", 753.200829, 659.646308, 753.143796, 640.07465, 753.400909, 628.991672, "C", 754.039429, 601.468015, 756.957422, 583.952137, 789.890724, 577.818051, "C", 802.160603, 575.53269, 827.907742, 571.829351, 828.249556, 570.235368],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 20816.666666666668,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 742.608747, 625.742814, 754.654585, 626.099108, "C", 766.700423, 626.455402, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 778.104229, 589.283397, 784.915646, 581.535689, "C", 790.074191, 575.668055, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 23416.666666666668,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.772164, 584.922953, 724.846032, 586.290053, "C", 745.459881, 587.940598, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.606208, 659.20036, 753.229131, 632.684236, "C", 753.873736, 605.245173, 756.763711, 581.652194, 788.690297, 575.369819, "C", 808.267254, 571.51755, 827.574578, 569.646602, 827.92338, 569.239752],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 23425,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.458524, 585.097572, 725.690554, 586.612811, "C", 742.533935, 587.939855, 748.9768, 605.24387, 750.722717, 631.817253, "C", 751.339701, 641.207936, 751.796436, 661.810753, 751.663824, 667.376492, "C", 751.531212, 672.942231, 750.69072, 677.293124, 752.455472, 677.293121, "C", 754.220224, 677.293118, 753.200831, 675.415886, 753.20083, 667.531097, "C", 753.200829, 659.646308, 752.688756, 639.262578, 752.945869, 628.1796, "C", 753.584389, 600.655943, 756.957422, 583.952137, 789.890724, 577.818051, "C", 802.160603, 575.53269, 827.907742, 571.829351, 828.249556, 570.235368],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 23650,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 742.608747, 625.742814, 754.654585, 626.099108, "C", 766.700423, 626.455402, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 778.104229, 589.283397, 784.915646, 581.535689, "C", 790.074191, 575.668055, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534]
									}, {
										"t": 26250,
										"v": ["M", 681.563851, 578.675956, "C", 681.563851, 578.675956, 707.772164, 584.922953, 724.846032, 586.290053, "C", 745.459881, 587.940598, 749.855027, 611.278077, 751.768337, 637.839929, "C", 753.326708, 659.474284, 748.910722, 676.927401, 747.911537, 683.498514, "C", 746.912352, 690.069627, 749.929592, 695.112877, 753.402398, 695.112877, "C", 756.875204, 695.112877, 759.161764, 689.307899, 758.284739, 682.552149, "C", 757.407714, 675.796399, 752.606208, 659.20036, 753.229131, 632.684236, "C", 753.873736, 605.245173, 756.763711, 581.652194, 788.690297, 575.369819, "C", 808.267254, 571.51755, 827.574578, 569.646602, 827.92338, 569.239752],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 26258.333333333336,
										"v": ["M", 681.538876, 578.663778, "C", 681.538876, 578.663778, 706.458524, 585.097572, 725.690554, 586.612811, "C", 742.533935, 587.939855, 748.9768, 605.24387, 750.722717, 631.817253, "C", 751.339701, 641.207936, 751.796436, 661.810753, 751.663824, 667.376492, "C", 751.531212, 672.942231, 750.69072, 677.293124, 752.455472, 677.293121, "C", 754.220224, 677.293118, 753.200831, 675.415886, 753.20083, 667.531097, "C", 753.200829, 659.646308, 752.688756, 639.262578, 752.945869, 628.1796, "C", 753.584389, 600.655943, 756.957422, 583.952137, 789.890724, 577.818051, "C", 802.160603, 575.53269, 827.907742, 571.829351, 828.249556, 570.235368],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 26483.333333333336,
										"v": ["M", 663.025009, 576.839739, "C", 666.289852, 585.843083, 684.388888, 588.281904, 694.858363, 588.446047, "C", 704.464625, 588.786423, 714.836625, 587.984481, 722.550527, 591.785101, "C", 728.640807, 594.795811, 734.519235, 599.783171, 737.621289, 606.613979, "C", 740.723343, 613.444787, 742.608747, 625.742814, 754.654585, 626.099108, "C", 766.700423, 626.455402, 768.656358, 611.903469, 771.865886, 605.103681, "C", 775.075414, 598.303893, 778.104229, 589.283397, 784.915646, 581.535689, "C", 790.074191, 575.668055, 801.964037, 572.764086, 809.039363, 572.040263, "C", 829.856184, 569.910652, 836.423723, 565.871895, 840.281578, 560.991534],
										"e": [0, 0, 0.155, 1.005]
									}, {
										"t": 33333.333333333336,
										"v": ["M", 663.025009, 576.839739, "C", 667.814403, 582.432532, 683.467547, 585.010896, 693.938101, 585.076789, "C", 704.466207, 585.143044, 706.470095, 585.076959, 711.644904, 585.213651, "C", 717.174363, 585.359711, 720.729476, 585.146725, 727.285374, 586.382132, "C", 733.841272, 587.617539, 743.525965, 590.125982, 753.510808, 589.595451, "C", 763.495651, 589.06492, 772.942908, 583.899114, 776.576552, 581.416095, "C", 780.210196, 578.933076, 786.133887, 577.021902, 791.269115, 575.71976, "C", 795.950236, 574.532766, 797.2192, 574.171784, 808.840013, 573.03006, "C", 823.372125, 571.602306, 837.485839, 562.530623, 840.114851, 557.173249]
									}],
									"transform": {
										"data": {
											"o": {
												"x": 745.0771,
												"y": 535.406166,
												"type": "corner"
											},
											"t": {
												"x": -750.246898,
												"y": -550.088684
											}
										},
										"keys": {
											"s": [{
												"t": 10000,
												"v": {
													"x": 1.763569,
													"y": 1
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 16125,
												"v": {
													"x": 1.509723,
													"y": 1.127826
												}
											}, {
												"t": 21016.666666666668,
												"v": {
													"x": 1.344558,
													"y": 1.107589
												}
											}]
										}
									},
									"opacity": [{
										"t": 9583.333333333334,
										"v": 0
									}, {
										"t": 10000,
										"v": 1
									}]
								},
								"evQrI1MWBnR12": {
									"d": [{
										"t": 0,
										"v": ["M", 180.67, 526, "C", 126, 527.31, 68.89, 525.8, 64.13, 544.59, "C", 59.37, 563.38, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 214.98, 566.1, 252.45, 564.61, "C", 290.14, 563.11, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 625.842171, 575.777161, 672.85, 572.56, "C", 719.857829, 569.342839, 739.963599, 567.050846, 785.93, 565.665423]
									}, {
										"t": 10000,
										"v": ["M", 161.161667, 517.447718, "C", 106.559447, 520.468064, 35.421455, 522.126553, 31.776267, 537.96463, "C", 28.131079, 553.802707, 162.741879, 549.698798, 188.561879, 552.318798, "C", 214.381879, 554.938798, 227.825368, 566.641775, 265.295368, 565.151775, "C", 302.985368, 563.651775, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 671.550124, 579.18495, 721.082519, 574.382013, "C", 770.614914, 569.579076, 775.366089, 559.767992, 821.33249, 558.382569]
									}, {
										"t": 20000,
										"v": ["M", 128.529541, 511.438802, "C", 74.188123, 514.563601, 7.153872, 522.245287, 2.393872, 541.035287, "C", -2.366128, 559.825287, 150.31, 554.91, 176.13, 557.53, "C", 201.95, 560.15, 214.950607, 564.738252, 252.45, 564.61, "C", 290.164051, 564.481014, 386.96, 571.29, 474.09, 573.97, "C", 562.43, 576.68, 684.991366, 575.430258, 731.999195, 572.213097, "C", 779.007024, 568.995936, 796.140413, 561.948222, 842.106814, 560.562799]
									}, {
										"t": 27350,
										"v": ["M", 131.058728, 513.124614, "C", 77.096243, 516.083305, 10.529435, 523.356649, 5.802627, 541.147814, "C", 1.07582, 558.938978, 152.687308, 554.284977, 178.327259, 556.765703, "C", 203.967211, 559.24643, 216.877163, 563.59078, 254.115065, 563.469346, "C", 291.566128, 563.347216, 387.6871, 569.794251, 474.209526, 572.331789, "C", 561.933514, 574.89773, 683.640235, 573.714422, 730.320269, 570.668278, "C", 777.000304, 567.622135, 794.014218, 560.949062, 839.660086, 559.637285]
									}, {
										"t": 33333.333333333336,
										"v": ["M", 133.117635, 514.496964, "C", 79.463624, 517.320434, 13.277342, 524.261364, 8.577555, 541.239417, "C", 3.877768, 558.21747, 154.622576, 553.776171, 180.115958, 556.143521, "C", 205.60934, 558.51087, 218.445493, 562.656671, 255.470526, 562.540786, "C", 292.707502, 562.424238, 388.279003, 568.576624, 474.306827, 570.998188, "C", 561.529345, 573.446858, 682.540335, 572.317631, 728.953525, 569.410705, "C", 775.366715, 566.50378, 792.28337, 560.135687, 837.668306, 558.883862]
									}],
									"transform": {
										"data": {
											"s": {
												"x": 0.927629,
												"y": 1.015579
											},
											"t": {
												"x": -487.656479,
												"y": -590.840012
											}
										},
										"keys": {
											"o": [{
												"t": 0,
												"v": {
													"x": 465.952105,
													"y": 575.260131,
													"type": "corner"
												}
											}, {
												"t": 10000,
												"v": {
													"x": 478.164179,
													"y": 585.056692,
													"type": "corner"
												}
											}]
										}
									},
									"stroke-width": [{
										"t": 0,
										"v": 16
									}, {
										"t": 10000,
										"v": 9
									}, {
										"t": 33333.333333333336,
										"v": 8
									}]
								},
								"evQrI1MWBnR13": {
									"transform": {
										"data": {
											"t": {
												"x": -501.015564,
												"y": -383.442199
											}
										},
										"keys": {
											"o": [{
												"t": 0,
												"v": {
													"x": 481.086974,
													"y": 375.883055,
													"type": "corner"
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 5833.333333333334,
												"v": {
													"x": 507.228127,
													"y": 384.063456,
													"type": "corner"
												}
											}]
										}
									}
								},
								"evQrI1MWBnR28": {
									"transform": {
										"data": {
											"o": {
												"x": 458.479999,
												"y": 395.659144,
												"type": "corner"
											},
											"t": {
												"x": -458.479998,
												"y": -395.659143
											}
										},
										"keys": {
											"r": [{
												"t": 0,
												"v": -12.169636,
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 6666.666666666667,
												"v": 0
											}]
										}
									}
								},
								"evQrI1MWBnR36": {
									"d": [{
										"t": 0,
										"v": ["M", 561.615997, 527.94542, "C", 587.516991, 515.857345, 613.861731, 480.089109, 622.442752, 447.462645, "L", 648.337964, 437.569033, "C", 634.575623, 483.821969, 599.987985, 513.229153, 585.051476, 519.933663, "Z"],
										"e": [0, 0, 0.58, 1]
									}, {
										"t": 5833.333333333334,
										"v": ["M", 587.7, 496.19, "C", 602.84, 480.88, 614.77, 466.35, 621.59, 448.05, "L", 641.83, 439.6, "C", 629.93, 465.36, 610.83, 483.17, 603.83, 487.89, "Z"]
									}],
									"transform": {
										"data": {
											"t": {
												"x": -614.765015,
												"y": -467.894989
											}
										},
										"keys": {
											"o": [{
												"t": 0,
												"v": {
													"x": 625.842184,
													"y": 431.908086,
													"type": "cusp",
													"end": {
														"x": 625.378043,
														"y": 440.84339
													}
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 5833.333333333334,
												"v": {
													"x": 614.765015,
													"y": 467.894989,
													"type": "cusp",
													"start": {
														"x": 618.848502,
														"y": 460.688724
													}
												}
											}],
											"r": [{
												"t": 0,
												"v": -8.452572,
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 5833.333333333334,
												"v": 0
											}]
										}
									}
								},
								"evQrI1MWBnR37": {
									"d": [{
										"t": 0,
										"v": ["M", 589.37969, 510.149874, "C", 615.9258, 494.03429, 657.911619, 455.876889, 663.131561, 384.794632, "L", 681.375376, 378.623921, "C", 678.163539, 453.079043, 630.079955, 494.845148, 604.075234, 506.652563, "Z"],
										"e": [0, 0, 0.58, 1]
									}, {
										"t": 5833.333333333334,
										"v": ["M", 618.26, 480.06, "C", 632.175, 466.881986, 655.443981, 435.384786, 660.26, 389.34, "L", 677.9, 380, "C", 671.98, 438.86, 648.08, 467.05, 630.51, 474.19, "Z"]
									}],
									"transform": {
										"data": {
											"t": {
												"x": -648.080017,
												"y": -430.029999
											}
										},
										"keys": {
											"o": [{
												"t": 0,
												"v": {
													"x": 654.919029,
													"y": 389.288638,
													"type": "cusp",
													"end": {
														"x": 654.40879,
														"y": 399.691121
													}
												},
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 5833.333333333334,
												"v": {
													"x": 648.080017,
													"y": 430.029999,
													"type": "cusp",
													"start": {
														"x": 653.948513,
														"y": 422.986988
													}
												}
											}],
											"r": [{
												"t": 0,
												"v": -13.832711,
												"e": [0, 0, 0.58, 1]
											}, {
												"t": 5833.333333333334,
												"v": 0
											}]
										}
									}
								},
								"evQrI1MWBnR39": {
									"d": [{
										"t": 0,
										"v": ["M", 506.570001, 540.490001, "C", 506.570001, 531.250001, 506.180001, 524.2, 506.180001, 501.56, "C", 535.640001, 493, 562.554999, 460.865001, 574.274999, 423.000002, "L", 503.062615, 423, "C", 503.062615, 423, 418.04, 444.88, 378.13, 455.86, "C", 343.51, 465.39, 342.685, 522.07, 342.685, 535.010642, "L", 342.685, 557.380642, "L", 506.570001, 558.449749, "Z"],
										"e": [0.39, 0.575, 0.565, 1]
									}, {
										"t": 10000,
										"v": ["M", 498.47, 543.68, "C", 498.47, 534.44, 498.08, 527.39, 498.08, 504.75, "C", 527.54, 496.19, 554.19, 472.75, 567.2, 442.3, "L", 518.2, 439.83, "C", 518.2, 439.83, 430.645, 469.08, 390.735, 480.06, "C", 373.058533, 486.035111, 372.88504, 501.56, 373.376507, 516.560001, "L", 373.376507, 558.86, "L", 497.17, 562.19, "Z"]
									}]
								},
								"evQrI1MWBnR40": {
									"transform": {
										"data": {
											"t": {
												"x": -222.514676,
												"y": -529.720092
											}
										},
										"keys": {
											"o": [{
												"t": 11000,
												"v": {
													"x": 251.611601,
													"y": 531.053002,
													"type": "corner"
												}
											}, {
												"t": 17500,
												"v": {
													"x": 247.842999,
													"y": 551.484803,
													"type": "corner"
												}
											}],
											"r": [{
												"t": 11000,
												"v": 0,
												"e": [0.47, 0, 0.995, 0.995]
											}, {
												"t": 17500,
												"v": -9.820318,
												"e": [0.96, -0.005, 1, 1]
											}, {
												"t": 17750,
												"v": -31.996994
											}]
										}
									},
									"fill": [{
										"t": 14416.666666666668,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.87
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 1
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR40-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 135.03,
												"y": 248.84
											},
											"to": {
												"x": 240.62,
												"y": 538.94
											}
										}
									}, {
										"t": 17166.666666666668,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.87
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 0
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR40-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 135.03,
												"y": 248.84
											},
											"to": {
												"x": 240.62,
												"y": 538.94
											}
										}
									}, {
										"t": 17500,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.87
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 0
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR40-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 135.03,
												"y": 248.84
											},
											"to": {
												"x": 240.62,
												"y": 538.94
											}
										},
										"e": [0.96, -0.005, 1, 1]
									}, {
										"t": 17750,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.907377
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 0.57
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR40-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 290.644572,
												"y": 255.938476
											},
											"to": {
												"x": 181.453396,
												"y": 513.417915
											}
										}
									}]
								},
								"evQrI1MWBnR41": {
									"transform": {
										"data": {
											"t": {
												"x": -773.535004,
												"y": -380.014999
											}
										},
										"keys": {
											"o": [{
												"t": 6666.666666666667,
												"v": {
													"x": 781.611337,
													"y": 380.014999,
													"type": "corner"
												},
												"e": [0.445, 0.05, 0.55, 0.95]
											}, {
												"t": 10833.333333333334,
												"v": {
													"x": 782.296337,
													"y": 410.754999,
													"type": "corner"
												}
											}],
											"r": [{
												"t": 6666.666666666667,
												"v": 0,
												"e": [0.445, 0.05, 0.55, 0.95]
											}, {
												"t": 10833.333333333334,
												"v": 6.829718
											}]
										}
									},
									"fill": [{
										"t": 9000,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.87
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 1
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR41-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 704.29,
												"y": 248.84
											},
											"to": {
												"x": 809.88,
												"y": 538.94
											}
										}
									}, {
										"t": 10666.666666666668,
										"v": {
											"t": "g",
											"s": [{
												"c": {
													"r": 104,
													"g": 218,
													"b": 240,
													"a": 1
												},
												"o": 0
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.54
											}, {
												"c": {
													"r": 68,
													"g": 197,
													"b": 223,
													"a": 1
												},
												"o": 0.87
											}, {
												"c": {
													"r": 79,
													"g": 175,
													"b": 195,
													"a": 0
												},
												"o": 1
											}],
											"r": "evQrI1MWBnR41-fill",
											"gt": [1, 0, 0, 1, 0, 0],
											"f": {
												"x": 704.28992,
												"y": 248.839883
											},
											"to": {
												"x": 809.879916,
												"y": 538.939959
											}
										}
									}]
								}
							},
							"s": "MDOA2M2JkNjRhNFmI3YjRhM2I2UYWJiMWIwNjQB3Y1M3NTc1NzXU3NTc1REY3MKDc1NzU3NVE3QNTc1NzU3NUwA3NTc1NzU3NTDc4NmU2NGE2YCWJiNEFhN2E1BUmI2TGFiYjFMWYjA2NDdjNzEM2ZTY0YWJiNKmE3YjRhM2I2UTWFiYjFiMGIP1NjQ3YzczNmVU2NGE4YWJhZCWFlNjRIN2M3PMzZlNjRhM2FTlYjZhN2I0YjFBhM2I2YTdRNUjQ3Y2E4YTNhPZWI1YTc2ZTYM0YjViMmE3YTHdhNjY0N2M3MPzcwNzRiZg|"
						}],
						"options": "MDWAxMDgyMjk3YNTdiNjg3OTdiHMjk0MTI5NzMQ3NjY4NmIyOTDg0"
					}, '__SVGATOR_PLAYER__', window)
					]]>
				</script>
			</svg>

		</div>
		<div class="w-oops-content">
			<h1 class="w-oops">Oops</h1>
			<p class="w-who">Who spilled the paint?</p>
			<p class="w-wrong">This is wrong. This page can not be found, it has probably run away 😅.</p>
			<a class="w-button" href="javascript:window.history.go(-1);">GO BACK</a>
		</div>
	</div>
</body>

</html>