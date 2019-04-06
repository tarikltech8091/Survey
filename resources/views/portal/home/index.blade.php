@extends('portal.layout.master')
@section('content')
<div class="home">
    <br><br>
    <style>
        #audioControl img {
            width: 50px;
            height: 50px;
        }

        #pause {
            display: none;
        }

        #audioControl img {
            width: 50px;
            height: 50px;
        }

        #pause {
            display: none;
        }

    </style>


    <div class="custom-audio">

        <ul style="padding: 0 10px">

            <li class="active">

                <div class="row border-bottom" style="margin-bottom: 0px; margin-top: 0px">
                    <div class="col s1 m1 l1 xl1">
                        &nbsp;
                    </div>
                    <div class="col s9 m9 l9 xl9">
                        <div class="title">
                                Ravel Bolero
                        </div>
                    </div>
                    <div class="col s2 m2 l2 xl2">

                        <div class="onlineradio">
                            <p>
                                <audio id="yourAudio"  data-ids="1">
                                    <source src='http://www.archive.org/download/CanonInD_261/CanoninD.mp3' type='audio/mpeg' preload="auto" />
                                </audio>
                                 <a id="audioControl" href="#">
                                    <img src="http://etc-mysitemyway.s3.amazonaws.com/icons/legacy-previews/icons/glossy-black-3d-buttons-icons-media/002110-glossy-black-3d-button-icon-media-a-media22-arrow-forward1.png" id="play"/>
                                    <img src="https://www.wisc-online.com/asset-repository/getfile?id=415&getType=view" id="pause"/>
                                </a>
                            </p>
                        </div>

                    </div>
                </div>

            </li>

            <li>

                <div class="row border-bottom" style="margin-bottom: 0px; margin-top: 0px">
                    <div class="col s1 m1 l1 xl1">
                        &nbsp;
                    </div>
                    <div class="col s9 m9 l9 xl9">
                        <div class="title">
                                Ravel Bolero
                        </div>
                    </div>
                    <div class="col s2 m2 l2 xl2">

                        <div class="onlineradio">
                            <p>
                                <audio id="yourAudio" data-ids="2">
                                    <source src='http://www.archive.org/download/bolero_69/Bolero.mp3' type='audio/mpeg' preload="auto" />
                                </audio>
                                <a id="audioControl" href="#">
                                    <img src="http://etc-mysitemyway.s3.amazonaws.com/icons/legacy-previews/icons/glossy-black-3d-buttons-icons-media/002110-glossy-black-3d-button-icon-media-a-media22-arrow-forward1.png" id="play"/>
                                    <img src="https://www.wisc-online.com/asset-repository/getfile?id=415&getType=view" id="pause"/>
                                </a>
                            </p>
                        </div>

                    </div>
                </div>


                {{--<div class="row border-bottom" style="margin-bottom: 0px; margin-top: 0px">--}}
                    {{--<div class="col s1 m1 l1 xl1">--}}
                        {{--&nbsp;--}}
                    {{--</div>--}}
                    {{--<div class="col s9 m9 l9 xl9">--}}
                        {{--<div class="title">--}}
                            {{--<a href="http://www.archive.org/download/bolero_69/Bolero.mp3">--}}
                                {{--Ravel Bolero--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col s2 m2 l2 xl2">--}}

                        {{--<div class="onlineradio">--}}
                            {{--<p>--}}
                                {{--<audio id="yourAudio2" ids="2">--}}
                                    {{--<source src='http://www.archive.org/download/bolero_69/Bolero.mp3' type='audio/mpeg' preload="auto" />--}}
                                {{--</audio>--}}
                                {{--<a id="audioControl" href="#">--}}
                                    {{--<p id="play"><i class="material-icons icon-middle">volume_up</i></p>--}}
                                    {{--<p id="pause"><i class="material-icons icon-middle">pause</i></p>--}}
                                    {{--<img src="http://etc-mysitemyway.s3.amazonaws.com/icons/legacy-previews/icons/glossy-black-3d-buttons-icons-media/002110-glossy-black-3d-button-icon-media-a-media22-arrow-forward1.png" id="play"/>--}}
                                    {{--<img src="https://www.wisc-online.com/asset-repository/getfile?id=415&getType=view" id="pause"/>--}}
                                {{--</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

            </li>

            <li>
                <div class="row border-bottom" style="margin-bottom: 0px; margin-top: 0px">
                    <div class="onlineradio">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                                    Ravel Bolerrerewew
                                </a>
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                                <p>
                                    <audio id="yourAudio">
                                        <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                                            patrikbkarl chamber symph
                                        </a>
                                        <source src='http://www.archive.org/download/bolero_69/Bolero.mp3' type='audio/mpeg' preload="auto" />
                                    </audio>
                                    <a id="audioControl" href="#">
                                        <img src="http://etc-mysitemyway.s3.amazonaws.com/icons/legacy-previews/icons/glossy-black-3d-buttons-icons-media/002110-glossy-black-3d-button-icon-media-a-media22-arrow-forward1.png" id="play"/>
                                        <img src="https://www.wisc-online.com/asset-repository/getfile?id=415&getType=view" id="pause"/>
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>


            </li>


            <li>
                <a href="http://www.archive.org/download/MoonlightSonata_755/Beethoven-MoonlightSonata.mp3">
                    Moonlight Sonata - Beethoven
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/CanonInD_261/CanoninD.mp3">
                    Canon in D Pachabel
                </a>
            </li>
            <li>
                <a href="http://www.archive.org/download/PatrikbkarlChamberSymph/PatrikbkarlChamberSymph_vbr_mp3.zip">
                    patrikbkarl chamber symph
                </a>
            </li>
        </ul>
        <br><br><br>
    </div>
</div>
@endsection
@section('JScript')
<script type="text/javascript">

    $(document).ready(function () {

    });

    var yourAudio = document.getElementById('yourAudio'),
        ctrl = document.getElementById('audioControl'),
        playButton = document.getElementById('play'),
        pauseButton = document.getElementById('pause');

    function toggleButton() {
        if (playButton.style.display === 'none') {
            playButton.style.display = 'block';
            pauseButton.style.display = 'none';
        } else {
            playButton.style.display = 'none';
            pauseButton.style.display = 'block';
        }
    }

    ctrl.onclick = function () {

        if (yourAudio.paused) {
            yourAudio.play();
        } else {
            yourAudio.pause();
        }

        toggleButton();

        // Prevent Default Action
        return false;
    };
</script>
@endsection