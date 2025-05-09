@if ($opt == 1 || $opt == 2 || $opt == 3)
    <!-- [ Front ] start -->
    <div class="card-container dark-card mb-3 mb-md-0" style="background-color: #2e2e2e;">
        <!-- [ Front-Card ] start -->
        <table width="100%" style="color: white; font-size: 12pt; letter-spacing:0.5pt;">
            <tr>
                <td colspan="2"
                    style="padding-top: 20px; padding-left: 30px; font-weight:700; font-family: Times New Roman;">
                    THIS PATIENT HAS A
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="padding-top: 5px; padding-left: 30px; font-weight:700; font-family: Times New Roman; color: #4d9cf0;">
                    MRI CONDITIONAL DEVICES
                </td>
            </tr>
            <tr>
                <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                    <img src="../assets/images/card/MR_icon.png" width="80" alt="Abbott Logo">
                </td>
                <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                    <img src="../assets/images/logo/abbott-logo-white.png" width="100" alt="Abbott Logo">
                </td>
            </tr>
        </table>
        <!-- [ Front-Card ] end -->
    </div>
    <!-- [ Front ] end -->
    <a href="javascript: void(0)" class=" text-center link-primary mt-3 mb-3 d-none d-md-block" data-bs-toggle="modal"
        data-bs-target="#viewFrontCard">View Fullscreen
        (Front)</a>

    <!-- [ Back ] start -->
    <div class="card-container blue-card mb-3 mb-md-0">
        <!-- [ Header ] start -->
        <table width="100%" class=" @if ($opt == 1) header-non-mri @else header-mri @endif">
            <tr>
                <td style="padding: 10px; padding-left: 15px;">
                    <img src="../assets/images/logo/abbott-logo-white.png" width="60" alt="Abbott Logo">
                </td>
                <td style="text-align: right;padding: 10px;padding-right: 15px;  font-weight:700; ">
                    Patient Identification Card
                </td>
            </tr>
        </table>
        <!-- [ Header ] end -->

        <!-- [ Patient details ] start -->
        <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
            <tr>
                <th style="padding-left: 15px; padding-top: 10px; padding-bottom: 2px; font-weight:700; width:30%;">
                    PATIENT
                </th>
                <td style="padding-top: 10px; padding-bottom: 2px; font-weight:700;">
                    {{ $data['implant_pt_name'] }}
                </td>
            </tr>
            <tr>
                <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                    I/C / MRN
                </th>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['implant_pt_icno'] }}
                </td>
            </tr>
        </table>
        <!-- [ Patient details ] end -->

        <!-- [ Pacemake & Model details ] start -->
        <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
            <tr>
                <th style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                </th>
                <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                    MODEL NO
                </th>
                <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                    SERIAL NO
                </th>
                <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                    IMPLANT DATE
                </th>
            </tr>
            <tr>
                <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                    PACEMAKER
                </th>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['generator_code'] }}
                </td>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['implant_generator_sn'] }}
                </td>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['implant_date'] }}
                </td>
            </tr>
            @foreach (array_chunk($data['models'], 3) as $modelRow)
                @foreach ($modelRow as $item)
                    <tr>
                        <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                            {{ $item['model_category'] }}
                        </th>
                        <td style="padding-bottom: 2px; font-weight:700;">
                            {{ $item['model_code'] }}
                        </td>
                        <td style="padding-bottom: 2px; font-weight:700;">
                            {{ $item['implant_model_sn'] }}
                        </td>
                        <td style="padding-bottom: 2px; font-weight:700;">
                            @if (($item['model_code'] ?? '-') === '-')
                                -
                            @else
                                {{ $data['implant_date'] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
        <!-- [ Pacemake & Model details ] end -->

        <!-- [ Physician details ] start -->
        <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
            <tr>
                <th style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                    PHYSICIAN
                </th>
                <td style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                    {{ $data['doctor_name'] }}
                </td>
                <td rowspan="3"
                    style="padding-bottom: 2px; font-weight:700;text-align: center;width:20%;padding-right: 15px;">
                    @if ($opt == 2)
                        <img src="../assets/images/card/1.5T_icon.JPG" width="60" alt="1.5TLogo">
                    @elseif($opt == 3)
                        <img src="../assets/images/card/3.0T_icon.jpeg" width="60" alt="3.0TLogo">
                    @endif
                </td>
            </tr>
            <tr>
                <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                    HOSPITAL
                </th>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['hospital_name'] }}
                </td>
            </tr>
            <tr>
                <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                    CONTACT NO
                </th>
                <td style="padding-bottom: 2px; font-weight:700;">
                    {{ $data['hospital_phoneno'] }}
                </td>
            </tr>
        </table>
        <!-- [ Physician details ] end -->

    </div>
    <!-- [ Back ] end -->

    <a href="javascript: void(0)" class="text-center link-primary mt-3 mb-3 d-none d-md-block" data-bs-toggle="modal"
        data-bs-target="#viewBackCard">View Fullscreen
        (Back)</a>
@else
    <div class="card-container mb-3">
        Front Card
    </div>
    <div class="card-container mb-3">
        Back Card
    </div>
@endif

<div class="modal fade" id="viewFrontCard" tabindex="-1" role="dialog" aria-labelledby="viewFrontCard"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-wrapper">
                    <!-- [ Front ] start -->
                    <div class="card-container-modal dark-card">
                        <table width="100%" style="color: white; font-size: 12pt; letter-spacing:0.5pt;">
                            <tr>
                                <td colspan="2"
                                    style="padding-top: 20px; padding-left: 30px; font-weight:700; font-family: Times New Roman;">
                                    THIS PATIENT HAS A
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding-top: 5px; padding-left: 30px; font-weight:700; font-family: Times New Roman; color: #4d9cf0;">
                                    MRI CONDITIONAL DEVICES
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                    <img src="../assets/images/card/MR_icon.png" width="80" alt="Abbott Logo">
                                </td>
                                <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                    <img src="../assets/images/logo/abbott-logo-white.png" width="100"
                                        alt="Abbott Logo">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- [ Front ] end -->
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewBackCard" tabindex="-1" role="dialog" aria-labelledby="viewBackCard"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-wrapper">
                    @if ($opt == 1 || $opt == 2 || $opt == 3)
                        <!-- [ Back ] start -->
                        <div class="card-container-modal blue-card mb-3 mb-md-0">
                            <!-- [ Header ] start -->
                            <table width="100%"
                                class=" @if ($opt == 1) header-non-mri @else header-mri @endif">
                                <tr>
                                    <td style="padding: 10px; padding-left: 15px;">
                                        <img src="../assets/images/logo/abbott-logo-white.png" width="60"
                                            alt="Abbott Logo">
                                    </td>
                                    <td
                                        style="text-align: right;padding: 10px;padding-right: 15px;  font-weight:700; ">
                                        Patient Identification Card
                                    </td>
                                </tr>
                            </table>
                            <!-- [ Header ] end -->

                            <!-- [ Patient details ] start -->
                            <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                <tr>
                                    <th
                                        style="padding-left: 15px; padding-top: 10px; padding-bottom: 2px; font-weight:700; width:30%;">
                                        PATIENT
                                    </th>
                                    <td style="padding-top: 10px; padding-bottom: 2px; font-weight:700;">
                                        {{ $data['implant_pt_name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                        I/C / MRN
                                    </th>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['implant_pt_icno'] }}
                                    </td>
                                </tr>
                            </table>
                            <!-- [ Patient details ] end -->

                            <!-- [ Pacemake & Model details ] start -->
                            <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                <tr>
                                    <th
                                        style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                    </th>
                                    <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                        MODEL NO
                                    </th>
                                    <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                        SERIAL NO
                                    </th>
                                    <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                        IMPLANT DATE
                                    </th>
                                </tr>
                                <tr>
                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                        PACEMAKER
                                    </th>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['generator_code'] }}
                                    </td>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['implant_generator_sn'] }}
                                    </td>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['implant_date'] }}
                                    </td>
                                </tr>
                                @foreach (array_chunk($data['models'], 3) as $modelRow)
                                    @foreach ($modelRow as $item)
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                {{ $item['model_category'] }}
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $item['model_code'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $item['implant_model_sn'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                @if (($item['model_code'] ?? '-') === '-')
                                                    -
                                                @else
                                                    {{ $data['implant_date'] }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                            <!-- [ Pacemake & Model details ] end -->

                            <!-- [ Physician details ] start -->
                            <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                <tr>
                                    <th
                                        style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                        PHYSICIAN
                                    </th>
                                    <td style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                        {{ $data['doctor_name'] }}
                                    </td>
                                    <td rowspan="3"
                                        style="padding-bottom: 2px; font-weight:700;text-align: center;width:20%;padding-right: 15px;">
                                        @if ($opt == 2)
                                            <img src="../assets/images/card/1.5T_icon.JPG" width="60"
                                                alt="1.5TLogo">
                                        @elseif($opt == 3)
                                            <img src="../assets/images/card/3.0T_icon.jpeg" width="60"
                                                alt="3.0TLogo">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                        HOSPITAL
                                    </th>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['hospital_name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                        CONTACT NO
                                    </th>
                                    <td style="padding-bottom: 2px; font-weight:700;">
                                        {{ $data['hospital_phoneno'] }}
                                    </td>
                                </tr>
                            </table>
                            <!-- [ Physician details ] end -->

                        </div>
                        <!-- [ Back ] end -->
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
