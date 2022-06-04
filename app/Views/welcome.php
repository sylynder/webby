<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to Webby</title>
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
        }
    </style>
</head>

<body class="antialiased bg-primary">
    <div class="w-screen h-screen flex justify-center items-center dark:bg-gray-900">
        <div class="relative flex items-top justify-center min-h-screen dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                <div class="flex justify-center pt-8 items-center sm:pt-0">
                    <svg class="h-16 w-auto text-gray-700 sm:h-20" viewBox="0 0 1122.000000 420.000000" fill="none" preserveAspectRatio="xMidYMid meet">
                        <g clip-path="url(#clip0)" transform="translate(0.000000,420.000000) scale(0.100000,-0.100000)" fill="#6d00cc" stroke="none">
                            <path d="M5485 3789 c-121 -92 -221 -174 -223 -182 -2 -8 3 -18 10 -24 10 -8
                                69 32 233 158 121 92 221 174 223 182 2 8 -3 18 -10 24 -10 8 -69 -32 -233
                                -158z" />
                            <path d="M7415 3789 c-121 -92 -221 -174 -223 -182 -2 -8 3 -18 10 -24 10 -8
                                69 32 233 158 121 92 221 174 223 182 2 8 -3 18 -10 24 -10 8 -69 -32 -233
                                -158z" />
                            <path d="M5475 3629 c-121 -92 -221 -174 -223 -182 -2 -8 3 -18 10 -24 10 -8
                                69 32 233 158 121 92 221 174 223 182 2 8 -3 18 -10 24 -10 8 -69 -32 -233
                                -158z" />
                            <path d="M7395 3629 c-121 -92 -221 -174 -223 -182 -2 -8 3 -18 10 -24 10 -8
                                69 32 233 158 121 92 221 174 223 182 2 8 -3 18 -10 24 -10 8 -69 -32 -233
                                -158z" />
                            <path d="M7453 3532 l-223 -167 3 -995 c3 -1100 -1 -1027 68 -1178 142 -315
                                506 -510 861 -463 339 45 607 273 694 592 24 88 24 280 0 368 -89 323 -359
                                550 -704 593 -144 18 -299 -6 -444 -67 -17 -7 -18 32 -18 739 0 410 -3 746 -7
                                746 -5 0 -108 -76 -230 -168z m769 -1641 c280 -108 368 -449 171 -662 -92 -99
                                -204 -149 -333 -149 -129 0 -241 50 -333 149 -158 172 -136 444 48 591 50 40
                                85 59 155 82 75 25 213 20 292 -11z" />
                            <path d="M5517 3519 l-228 -173 3 -985 c4 -978 4 -987 25 -1054 92 -288 301
                                -485 598 -562 94 -25 303 -26 395 -2 307 81 528 292 606 578 24 88 24 280 0
                                368 -88 322 -359 550 -704 593 -143 18 -299 -6 -444 -67 -17 -7 -18 34 -20
                                735 l-3 742 -228 -173z m732 -1618 c86 -27 140 -61 204 -130 77 -84 101 -148
                                101 -271 0 -123 -24 -187 -101 -271 -92 -99 -204 -149 -333 -149 -129 0 -241
                                50 -333 149 -77 84 -101 148 -101 271 0 76 4 107 23 153 26 67 112 165 178
                                204 107 62 248 80 362 44z" />
                            <path d="M330 3120 c0 -20 7 -20 285 -20 278 0 285 0 285 20 0 20 -7 20 -285
                                20 -278 0 -285 0 -285 -20z" />
                            <path d="M2570 3120 c0 -20 7 -20 285 -20 278 0 285 0 285 20 0 20 -7 20 -285
                                20 -278 0 -285 0 -285 -20z" />
                            <path d="M330 3040 c0 -20 7 -20 285 -20 278 0 285 0 285 20 0 20 -7 20 -285
                                20 -278 0 -285 0 -285 -20z" />
                            <path d="M2570 3040 c0 -20 7 -20 285 -20 278 0 285 0 285 20 0 20 -7 20 -285
                                20 -278 0 -285 0 -285 -20z" />
                            <path d="M350 2968 c1 -7 126 -497 279 -1088 l278 -1075 249 0 248 0 132 560
                                c72 308 146 623 164 700 25 105 35 135 41 120 5 -11 79 -319 164 -685 86 -366
                                158 -673 161 -682 5 -17 26 -18 247 -18 l242 0 283 1068 c156 587 286 1077
                                289 1090 l5 22 -281 0 c-154 0 -281 -3 -281 -8 0 -16 -290 -1396 -295 -1400
                                -8 -8 -9 -3 -165 693 -82 369 -152 680 -155 693 l-5 22 -213 -2 -212 -3 -157
                                -689 c-87 -379 -160 -691 -163 -694 -3 -3 -7 -3 -10 0 -3 2 -69 316 -147 696
                                l-142 692 -278 0 c-216 0 -278 -3 -278 -12z" />
                            <path d="M9120 2580 c0 -19 7 -20 260 -20 253 0 260 1 260 20 0 19 -7 20 -260
                                20 -253 0 -260 -1 -260 -20z" />
                            <path d="M10300 2580 c0 -19 7 -20 260 -20 253 0 260 1 260 20 0 19 -7 20
                                -260 20 -253 0 -260 -1 -260 -20z" />
                            <path d="M9120 2500 c0 -19 7 -20 260 -20 253 0 260 1 260 20 0 19 -7 20 -260
                                20 -253 0 -260 -1 -260 -20z" />
                            <path d="M10300 2500 c0 -19 7 -20 260 -20 253 0 260 1 260 20 0 19 -7 20
                                -260 20 -253 0 -260 -1 -260 -20z" />
                            <path d="M3921 2479 c-301 -39 -560 -243 -674 -530 -199 -498 78 -1046 591
                                -1171 109 -26 285 -29 384 -5 246 60 454 230 577 475 l31 62 -246 0 -246 0
                                -49 -44 c-63 -56 -121 -84 -203 -98 -122 -20 -262 20 -340 98 -42 42 -86 127
                                -89 171 l-2 28 612 3 612 2 7 56 c9 77 -2 217 -26 311 -26 105 -106 263 -174
                                345 -139 168 -331 271 -556 298 -94 11 -117 11 -209 -1z m191 -410 c120 -25
                                226 -107 268 -205 35 -80 63 -74 -350 -74 l-369 0 15 42 c45 129 130 204 264
                                234 71 16 107 17 172 3z" />
                            <path d="M9155 2378 c13 -35 139 -358 280 -718 141 -360 267 -682 280 -716
                                l23 -61 -127 -309 -127 -309 250 -3 c137 -1 253 1 257 5 7 7 819 2159 819
                                2170 0 2 -116 2 -257 1 l-256 -3 -155 -465 c-85 -256 -157 -467 -159 -470 -8
                                -9 -19 21 -178 479 l-160 461 -257 0 -257 0 24 -62z" />
                        </g>
                    </svg>
                </div>

                <section class="dark:bg-gray-900">
                    <div class="container px-6 py-10 mx-auto">
                        <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 xl:gap-12 md:grid-cols-1 xl:grid-cols-3">

                            <div class="p-8 bg-white shadow space-y-3 border-2 border-[#6d00cc] dark:border-white rounded-xl">

                                <span class="inline-block text-blue-500 dark:text-blue-400">
                                    <svg viewBox="0 0 512 512" fill="none" stroke="#6d00cc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-8 h-8 text-gray-500">
                                        <rect x="32" y="96" width="64" height="368" rx="16" ry="16" style="fill:none;stroke-linejoin:round;stroke-width:32px"></rect>
                                        <line x1="112" y1="224" x2="240" y2="224" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                        <line x1="112" y1="400" x2="240" y2="400" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                        <rect x="112" y="160" width="128" height="304" rx="16" ry="16" style="fill:none;stroke-linejoin:round;stroke-width:32px"></rect>
                                        <rect x="256" y="48" width="96" height="416" rx="16" ry="16" style="fill:none;stroke-linejoin:round;stroke-width:32px"></rect>
                                        <path d="M422.46,96.11l-40.4,4.25c-11.12,1.17-19.18,11.57-17.93,23.1l34.92,321.59c1.26,11.53,11.37,20,22.49,18.84l40.4-4.25c11.12-1.17,19.18-11.57,17.93-23.1L445,115C443.69,103.42,433.58,94.94,422.46,96.11Z" style="fill:none;stroke-linejoin:round;stroke-width:32px"></path>
                                    </svg>
                                </span>

                                <h1 class="text-2xl  font-semibold text-gray-700 capitalize dark:text-gray-900">
                                    <a href="https://webby.sylynder.com/docs" target="_blank" class="underline text-gray-900 dark:text-gray-400">Documentation</a>
                                </h1>

                                <p class="text-gray-500 dark:text-gray-600">
                                    Webby's documentation is made to simply guide and direct developers especially beginners to quickly start working on a project as quick as possible.
                                </p>

                            </div>

                            <div class="p-8 bg-white shadow space-y-3 border-2 border-[#6d00cc] dark:border-white rounded-xl">

                                <span class="inline-block text-blue-500 dark:text-blue-400">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#6d00cc" stroke-width="2" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </span>

                                <h1 class="text-2xl  font-semibold text-gray-700 capitalize dark:text-gray-900">
                                    <a href="https://heartofphp.com" target="_blank" class="underline text-gray-900 dark:text-gray-400">Heart of PHP</a>
                                </h1>

                                <p class="text-gray-500 dark:text-gray-600">
                                    🐘 A Community for PHP developers, especially beginners to learn and know more about the PHP programming language and also presents guidance to develop real word applications without complexities.
                                </p>

                            </div>

                            <div class="p-8 bg-white shadow space-y-3 border-2 border-[#6d00cc] dark:border-white rounded-xl">

                                <span class="inline-block text-blue-500 dark:text-blue-400">
                                    <svg fill="none" stroke="#6d00cc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </span>

                                <h1 class="text-2xl  font-semibold text-gray-700 capitalize dark:text-gray-900">
                                    <a href="https://webby.sylynder.com/blogs" target="_blank" class="underline text-gray-900 dark:text-gray-400">Know The Tips</a>
                                </h1>

                                <p class="text-gray-500 dark:text-gray-600">
                                    A resource to know about what happens in the webby development labs in the form of tutorials, blogs and news.
                                </p>

                            </div>

                        </div>
                    </div>
                </section>

                <div class="fixed inset-x-0 lg:inset-x-auto bottom-6 lg:right-8 xl:right-10 xl:bottom-8"></div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left">
                        <div class="flex items-center">
                            Rendered in &nbsp; <strong> {elapsed_time} </strong> &nbsp; seconds | &nbsp; <strong>{memory_usage}</strong> &nbsp; memory used.
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        <?php echo (ENVIRONMENT === 'development') ?  'Webby <strong>v' . WEBBY_VERSION . ' (PHP v' . phpversion() . ')</strong>' : '' ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>