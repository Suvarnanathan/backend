<style>
@page { margin: 0px; }

    .leftTitle {
        color: white;
        text-align: left;
        font-size: 22px;
        font-weight: bold;
        padding-left: 4mm;
        margin-top: 6mm;
        margin-bottom: 4mm;
    }
    .leftContent {
        color: white;
        padding-left: 4mm;
        text-align: left;
        margin-top: 4mm;
        margin-bottom: 2mm;
        font-size: 16px;
        font-weight: bold;
    }
    .rightTitle {
        text-align: left;
        font-size: 22px;
        font-weight: bold;
        padding:2mm;
        margin-left: 7mm;
    }
    .rightContent {
        color: rgb(66, 66, 66);
        text-align: left;
        font-size: 18px;
        padding:2mm;
        margin-left: 7mm;
        padding-top:0mm;
        margin-right:4mm;
        margin-top:-2mm;
        margin-bottom:2mm;
    }
    table{
        /* table-layout: fixed; */
        border-collapse: collapse;
        border:"0";
    }
    body{
        font-family: sans-serif;
        /* background-color: #535559; */
        background-image: url({{$bgimage}});
    }
    .rightTr{
        margin-top:10mm;

    }
    /* .right{
        background-color: #e2e3e5;
    }
    .left{
        background-color: #535559;
    } */
    
</style>

<div id="main" width="220mm" >
        <div class="left" style="width: 60mm;background-color: #535559;text-align: center;vertical-align: top;float:left;position:">
            <div style="text-align: center;vertical-align: center;margin-top:4mm">
                <div style="text-align: center;">
                    <img src="{{ $image }}" alt="profile" style="padding: 0;width:150px; height: 150px; border-radius: 75px 75px 75px 75px;">
                </div>
            </div>
            <div>
                <div style="text-align: center;">
                    <div class="leftTitle" style="text-align: center;padding: 0;font-size: 18px;">{{ ucfirst($user->personalInfo->first_name) }}
                        {{ ucfirst($user->personalInfo->last_name) }}</div>
                </div>
            </div>
            <div style="line-height: 20px">
                <div>
                    @if($user->personalInfo->country_id)
                    <div class="leftTitle" style="border-top-color: rgb(255, 255, 255);"> Personal Info </div>
                    <div class="leftContent">Date of Birth <br> {{ $user->personalInfo->dob }}</div>
                    <div class="leftContent">Gender <br> {{ ucfirst($user->personalInfo->gender) }}</div>
                    <div class="leftContent">Email <br> <span style="font-size: 14px; font-weight:bold">{{ $user->email }}</span></div>
                    <div class="leftContent">Address @if($user->personalInfo->street_name) <br> {{ ucfirst($user->personalInfo->street_name) }}@endif
                    <br> {{ ucfirst($user->personalInfo->city) }}
                    <br> {{ ucfirst($user->personalInfo->country->name) }}
                    </div>
                    @endif
                </div>
            </div>
            <div style="line-height: 20px">
                <div>
                    @if(count($user->skills))
                    <div class="leftTitle" style="border-top-color: rgb(255, 255, 255);"> Skills</div>
                    @foreach ($user->skills as $userSkill)
                        <div class="leftContent" style="margin:0">{{ $userSkill->name }}</div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="right" style="width: 156mm;text-align: center;vertical-align: top;float:right;position:;">
                @if($user->personalInfo->about)
                <div style="margin-top:4mm">
                    <div>
                        <div class="rightTitle"> Summary </div>
                        <div class="rightContent" style="text-align:justify;">{{ ucfirst($user->personalInfo->about) }}</div>
                    </div>
                </div>
                @endif
                @if(count($user->jobExperience))
                <table >
                <tr>
                <td>
                        <div class="rightTitle" style="border-top-color: rgb(255, 255, 255);"> Experience </div>
                        @foreach ($user->jobExperience as $workExperience)
                            <div class="rightContent">
                                <span style="font-size: 18px; font-weight:bold">{{ $workExperience->jobSubCategory->name }}</span> <br>
                                {{ (Carbon\Carbon::parse($workExperience->start_date))->format('F Y') }} - @if($workExperience->end_date == null) Present @else {{ (Carbon\Carbon::parse($workExperience->end_date))->format('F Y') }}@endif<br>
                                {{ $workExperience->country->name }} <br>
                            </div>
                            @endforeach
                            </td>
                            </tr>
                </table>
                @endif

                @if(count($user->education))
                <table>
                    <tr>
                    <td>
                        <div class="rightTitle" style="border-top-color: rgb(255, 255, 255);"> Education </div>
                        @foreach ($user->education as $education)
                            <div class="rightContent">
                                <span style="font-size: 18px; font-weight:bold">{{ ucfirst($education->school) }}</span> <br>
                                {{ ucfirst($education->course_name) }}, {{ ucfirst($education->grade) }}<br>
                                {{ (Carbon\Carbon::parse($education->start_date))->format('F Y')}} - @if($education->end_date == null) Present @else {{ (Carbon\Carbon::parse($education->end_date))->format('F Y') }}@endif<br>
                            </div>
                        @endforeach
                    </td>
                    </tr>
                </table>
                @endif

                @if(count($user->certificates))
                <table>
                    <tr>
                    <td>                        
                        <div class="rightTitle" style="border-top-color: rgb(255, 255, 255);margin-bottom:1mm"> Certifications </div>
                        @foreach ($user->certificates as $userCertificate)
                            <div class="rightContent">
                                <span style="font-size: 18px; font-weight:bold">{{ ucfirst($userCertificate->name) }}</span><br>
                                {{ ucfirst($userCertificate->issued_organization) }}<br>
                                {{ (Carbon\Carbon::parse($userCertificate->start_date))->format('F Y') }} - {{ (Carbon\Carbon::parse($userCertificate->end_date))->format('F Y') }}
                            </div>
                        @endforeach
                </td>
                </tr>
                </table>
                @endif
                @if(count($user->licences))
                <table>
                <tr>
                <td>
                        <div class="rightTitle" style="border-top-color: rgb(255, 255, 255);margin-bottom:1mm"> Licenses </div>
                            <div class="rightContent">
                        @foreach ($user->licences as $userLicences)
                                <span style="font-size: 18px;">{{ ucfirst($userLicences->title) }}</span><br>
                        @endforeach
                        </div>
                </td>
                </tr>
                </table>
                @endif
        </div>
</div>
<script>
console.log(document.getElementById('main').offsetHeight>1122.519685);
console.log(document.getElementById('left').style.height);
console.log(document.getElementById('main').style.minHeight);
</script>
