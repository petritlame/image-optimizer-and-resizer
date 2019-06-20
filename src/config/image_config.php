<?php

return [

    /*
     * When calling `ImageOptimized` with `saveOriginal` parameter true, the optimized images
     * will be saved inside this directory in public path.
     */
    'upload_dir' => 'uploads/', //directory of your uploads assets

    /*
     * File supported formats
     */
    'supportedFormat' => [
        'image/png',
        'image/jpeg',
        'image/jpg'
    ],

    /*
     * The Compression rate in %, from 0, to 100, the higher the compression rate the
     * the higher resolution.
     */
    'compressRate' => 70,  //Recommended between 40 and 70s

    /*
     * The Compression rate in %, from 0, to 100, the higher the compression rate the
     * the higher resolution.
     */
    'resize_percent' => 50, //default resize half of original size

];
