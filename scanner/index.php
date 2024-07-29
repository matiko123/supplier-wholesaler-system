<?php
session_start();
$wholesaler_id=$_SESSION['wholesaler'];
$quantity=$_POST['quantity'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script nomodule="" defer="" src="js/index.runtime.0ba3fbea.js"></script>
    <script type="module" src="js/index.runtime.7930a9c0.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode/QR code Scanner</title>
    <meta name="description"
        content="A Progressive Web Application (PWA) that scans barcodes of various formats, using the Barcode Detection API.">
    <link rel="icon shortcut" href="../scanner/favicon.a05bdb0a.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.cbfc4d72.png">
    <link rel="manifest" href="manifest.webmanifest">
    <meta name="theme-color" content="#212529">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="css/index.83054abb.css">
    <link rel="stylesheet" href="css/index.96d2ebb1.css">
</head>

<body> <noscript>
        <div class="noscript"> JavaScript is required to properly view this site. </div>
    </noscript>
    <div class="global-actions" id="globalActions"> 
        <button id="historyBtn" title="History" style="display: none;">  
            <span>History</span> 
        </button> 
        <button id="settingsBtn" title="Settings" style="display: none;"> 
             <span>Settings</span> 
        </button>
        <button onclick="location.href='../list/'"> 
             <span>View Students</span> 
        </button>  
        
    </div>
    <dialog id="historyDialog" class="history-modal modal">
        <header > History <form method="dialog"> 
            <button type="submit"> 
                <span class="visually-hidden">Close</span> 
                </button> </form>
        </header>
        <ul id="historyList"></ul> 
        <button type="button" id="deleteHistoryBtn">Delete history</button>
    </dialog>
    <dialog id="settingsDialog" class="modal settings-modal">
        <header> 
            Settings 
            <form method="dialog"> 
            <button type="submit">
                <span class="visually-hidden">Close</span> 
                </button> 
            </form>
        </header>
        <form name="settings-form" autocomplete="false">
            <fieldset name="barcode-found-settings">
                <legend>When barcode is found...</legend>
                <ul>
                    <li><label><input type="checkbox" name="beep"> Beep</label></li>
                    <li><label><input type="checkbox" name="vibrate"> Vibrate (mobile)</label></li>
                    <li><label><input type="checkbox" name="openWebPage"> Open web pages automatically</label></li>
                    <li><label><input type="checkbox" name="openWebPageSameTab"> Open web pages in the same tab</label>
                    </li>
                    <li><label><input type="checkbox" name="addToHistory"> Add to history</label></li>
                </ul>
            </fieldset>
        </form>
    </dialog>
    <header class="site-header"> 
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" width="80" height="80"
            xml:space="preserve" class="logo" style="display: none;">
            <path fill="var(--links)"
                d="M93.867,51.2H8.533C3.814,51.2,0,55.014,0,59.733v85.333c0,4.719,3.814,8.533,8.533,8.533s8.533-3.814,8.533-8.533v-76.8 h76.8c4.719,0,8.533-3.814,8.533-8.533S98.586,51.2,93.867,51.2z">
            </path>
            <path fill="var(--links)"
                d="M503.467,51.2h-85.333c-4.719,0-8.533,3.814-8.533,8.533s3.814,8.533,8.533,8.533h76.8v76.8c0,4.719,3.814,8.533,8.533,8.533c4.719,0,8.533-3.814,8.533-8.533V59.733C512,55.014,508.186,51.2,503.467,51.2z">
            </path>
            <path fill="var(--links)"
                d="M503.467,358.4c-4.719,0-8.533,3.814-8.533,8.533v76.8h-76.8c-4.719,0-8.533,3.814-8.533,8.533s3.814,8.533,8.533,8.533h85.333c4.719,0,8.533-3.814,8.533-8.533v-85.333C512,362.214,508.186,358.4,503.467,358.4z">
            </path>
            <path fill="var(--links)"
                d="M93.867,443.733h-76.8v-76.8c0-4.719-3.814-8.533-8.533-8.533S0,362.214,0,366.933v85.333c0,4.719,3.814,8.533,8.533,8.533h85.333c4.719,0,8.533-3.814,8.533-8.533S98.586,443.733,93.867,443.733z">
            </path>
            <path fill="var(--links)"
                d="M503.467,247.467H8.533C3.814,247.467,0,251.281,0,256s3.814,8.533,8.533,8.533h494.933c4.719,0,8.533-3.814,8.533-8.533S508.186,247.467,503.467,247.467z">
            </path>
            <path fill="currentColor"
                d="M119.467,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C128,123.29,124.177,119.467,119.467,119.467z">
            </path>
            <path fill="currentColor"
                d="M153.6,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533V128C162.133,123.29,158.31,119.467,153.6,119.467z">
            </path>
            <path fill="currentColor"
                d="M187.733,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C196.267,123.29,192.444,119.467,187.733,119.467z">
            </path>
            <path fill="currentColor"
                d="M221.867,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533V128C230.4,123.29,226.577,119.467,221.867,119.467z">
            </path>
            <path fill="currentColor"
                d="M256,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C264.533,123.29,260.71,119.467,256,119.467z">
            </path>
            <path fill="currentColor"
                d="M290.133,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C298.667,123.29,294.844,119.467,290.133,119.467z">
            </path>
            <path fill="currentColor"
                d="M324.267,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C332.8,123.29,328.977,119.467,324.267,119.467z">
            </path>
            <path fill="currentColor"
                d="M358.4,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V128C366.933,123.29,363.11,119.467,358.4,119.467z">
            </path>
            <path fill="currentColor"
                d="M392.533,119.467c-4.71,0-8.533,3.823-8.533,8.533v93.867c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533V128C401.067,123.29,397.244,119.467,392.533,119.467z">
            </path>
            <path fill="currentColor"
                d="M119.467,281.6c-4.71,0-8.533,3.823-8.533,8.533v110.933c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533V290.133C128,285.423,124.177,281.6,119.467,281.6z">
            </path>
            <path fill="currentColor"
                d="M153.6,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533v-93.867C162.133,285.423,158.31,281.6,153.6,281.6z">
            </path>
            <path fill="currentColor"
                d="M187.733,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-93.867C196.267,285.423,192.444,281.6,187.733,281.6z">
            </path>
            <path fill="currentColor"
                d="M221.867,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533v-93.867C230.4,285.423,226.577,281.6,221.867,281.6z">
            </path>
            <path fill="currentColor"
                d="M256,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-93.867C264.533,285.423,260.71,281.6,256,281.6z">
            </path>
            <path fill="currentColor"
                d="M290.133,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-93.867C298.667,285.423,294.844,281.6,290.133,281.6z">
            </path>
            <path fill="currentColor"
                d="M324.267,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533S332.8,388.71,332.8,384v-93.867C332.8,285.423,328.977,281.6,324.267,281.6z">
            </path>
            <path fill="currentColor"
                d="M358.4,281.6c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-93.867C366.933,285.423,363.11,281.6,358.4,281.6z">
            </path>
            <path fill="currentColor"
                d="M392.533,281.6c-4.71,0-8.533,3.823-8.533,8.533v110.933c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533V290.133C401.067,285.423,397.244,281.6,392.533,281.6z">
            </path>
        </svg>
        <h1>Scan Product Barcode</h1>

    </header>
    <div class="toastContainer">
        <div id="toastContainer"></div>
    </div>
    <div class="container"> <a-tab-group no-scroll-controls="" no-tab-cycling=""> <a-tab slot="tab" role="heading"
                id="cameraTab" > <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                    class="bi bi-webcam" viewBox="0 0 16 16" style="display:none">
                    <path
                        d="M0 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H9.269c.144.162.33.324.531.475a6.785 6.785 0 0 0 .907.57l.014.006.003.002A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.224-.947l.003-.002.014-.007a4.473 4.473 0 0 0 .268-.148 6.75 6.75 0 0 0 .639-.421c.2-.15.387-.313.531-.475H2a2 2 0 0 1-2-2V6Zm2-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H2Z">
                    </path>
                    <path
                        d="M8 6.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm7 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z">
                    </path>
                </svg> 
                <span style="display:none">Use webcam</span> </a-tab> <a-tab-panel slot="panel" id="cameraPanel">
                <div class="scan-frame-container"> <resize-observer> <capture-photo facing-mode="environment"
                            no-image="" auto-play=""> <button type="button" id="scanBtn" class="scan-button" hidden="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z">
                                    </path>
                                </svg> Click to scan another barcode. </button> <span slot="capture-button"
                                hidden=""></span> <span slot="facing-mode-button-content" title="Switch camera"> <svg
                                    xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="22"
                                    height="22">
                                    <path
                                        d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 00-32 32v192a32 32 0 0032 32h352a32 32 0 0032-32V192a32 32 0 00-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z"
                                        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="32"></path>
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32"
                                        d="M124 158v-22h-24v22M335.76 285.22v-13.31a80 80 0 00-131-61.6M176 258.78v13.31a80 80 0 00130.73 61.8">
                                    </path>
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32"
                                        d="M196 272l-20-20-20 20M356 272l-20 20-20-20"></path>
                                </svg> <span class="visually-hidden">Switch camera</span> </span>
                            <div slot="actions">
                                <div class="zoom-controls" id="zoomControls" hidden=""> <button type="button"
                                        title="Zoom out" data-action="zoom-out"> <svg xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="18" fill="currentColor" class="bi bi-zoom-out"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z">
                                            </path>
                                            <path
                                                d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                d="M3 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z">
                                            </path>
                                        </svg> </button> <label id="zoomLevel"></label> <button type="button"
                                        title="Zoom in" data-action="zoom-in"> <svg xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="18" fill="currentColor" class="bi bi-zoom-in"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z">
                                            </path>
                                            <path
                                                d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z">
                                            </path>
                                        </svg> </button> </div>
                            </div>
                        </capture-photo> </resize-observer>
                    <div id="scanFrame" class="scan-frame" hidden=""> <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" >
                            <path
                                d="M336 448h56a56 56 0 0056-56v-56M448 176v-56a56 56 0 00-56-56h-56M176 448h-56a56 56 0 01-56-56v-56M64 176v-56a56 56 0 0156-56h56"
                                fill="none" stroke="var(--scan-frame-color)" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="10"></path>
                        </svg> </div>
                </div>
                <div id="scanInstructions" class="scan-instructions" hidden="">
                    <p>Align barcode in the center of the frame.</p>
                </div>
                <dialog id="cameraResults" class="results">
                </dialog><br>
                <button class="results" onclick="pasteAndDisplay('cameraResults')" style="background-color: rgb(4, 115, 174);"> 
                    Proceed
                </button>
            </a-tab-panel> <a-tab slot="tab" role="heading" id="fileTab"> <svg width="18" height="18"
                    viewBox="0 0 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" style="display:none">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-850.000000, -2681.000000)">
                            <g transform="translate(100.000000, 2626.000000)">
                                <g transform="translate(748.000000, 54.000000)">
                                    <g>
                                        <polygon id="Path" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M10.21,16.83 L12.96,13.29 L16.5,18 L5.5,18 L8.25,14.47 L10.21,16.83 Z M20,4 L23,4 L23,6 L20,6 L20,8.99 L18,8.99 L18,6 L15,6 L15,4 L18,4 L18,1 L20,1 L20,4 Z M18,20 L18,10 L20,10 L20,20 C20,21.1 19.1,22 18,22 L4,22 C2.9,22 2,21.1 2,20 L2,6 C2,4.9 2.9,4 4,4 L14,4 L14,6 L4,6 L4,20 L18,20 Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M16.5,18 L5.5,18 L8.25,14.47 L10.21,16.83 L12.96,13.29 L16.5,18 Z M17,7 L14,7 L14,6 L4,6 L4,20 L18,20 L18,10 L17,10 L17,7 Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg> <span style="display:none">Use image</span> </a-tab> <a-tab-panel slot="panel" id="filePanel"> <files-dropzone
                    id="dropzone" class="dropzone"> <span class="dropzone-instructions"> <svg width="50px" height="50px"
                            viewBox="0 0 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-850.000000, -2681.000000)">
                                    <g transform="translate(100.000000, 2626.000000)">
                                        <g transform="translate(748.000000, 54.000000)">
                                            <g>
                                                <polygon id="Path" points="0 0 24 0 24 24 0 24"></polygon>
                                                <path
                                                    d="M10.21,16.83 L12.96,13.29 L16.5,18 L5.5,18 L8.25,14.47 L10.21,16.83 Z M20,4 L23,4 L23,6 L20,6 L20,8.99 L18,8.99 L18,6 L15,6 L15,4 L18,4 L18,1 L20,1 L20,4 Z M18,20 L18,10 L20,10 L20,20 C20,21.1 19.1,22 18,22 L4,22 C2.9,22 2,21.1 2,20 L2,6 C2,4.9 2.9,4 4,4 L14,4 L14,6 L4,6 L4,20 L18,20 Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M16.5,18 L5.5,18 L8.25,14.47 L10.21,16.83 L12.96,13.29 L16.5,18 Z M17,7 L14,7 L14,6 L4,6 L4,20 L18,20 L18,10 L17,10 L17,7 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg> Click or drop an image to scan </span> </files-dropzone>
                <dialog id="fileResults" class="results">
                </dialog><br>
                <button id="output" class="results" onclick="pasteAndDisplay('fileResults')" style="background-color: rgb(4, 115, 174);"> 
                    Proceed
                </button>
                <div id="dozzer">gfdgd</div>
            </a-tab-panel> </a-tab-group> </div>
    <p class="supported-formats" id="supportedFormats" style="display: none;"></p>
    <script>
        function pasteAndDisplay(scanResult) {
               var text = document.getElementById(scanResult).innerText;
                location.href="../wholesaler/insertbarcode.php?wholesaler=<?php echo $wholesaler_id?>&quantity=<?php echo $quantity?>&barcode="+text;
        }
        </script>
    <script src="js/index.bb1ce697.js" type="module"></script>
    <script src="js/index.98a7b582.js" nomodule="" defer=""></script>
    <script src="js/index.ad39ef8d.js" type="module"></script>
    <script src="js/index.7cafa558.js" nomodule="" defer=""></script>
</body>

</html>