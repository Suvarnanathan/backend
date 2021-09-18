<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Resume</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

<style>
  @media print {
	 @page {
		 margin: 0;
		 size: A4;
	}
	 * {
		 -webkit-print-color-adjust: exact;
	}
}
 * {
	 font-family: "Montserrat", sans-serif;
	 margin: 0px;
	 padding: 0px;
	 box-sizing: border-box;
}
 body {
  background: #2c2b29;
	 width: 210mm !important;
	 height: 297mm !important;
	 margin: 0;
}
 .toCenter {
	 width: 210mm;
	 text-align: center;
	 display: flex;
	 justify-content: center;
	 align-items: center;
	 /* height: 297mm !important; */
}
 .grid-container {
	 margin: 0;
	 width: 210mm;
	 height: 297mm;
	 overflow: hidden;
	 box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
}
 .grid-container .zone-1 {
	 width: 50mm;
	 min-height: 297mm;
	 padding: 40px 20px;
   float:left;
	 padding-left: 35px;
	 background: #d1d1d1;
	 /* width: 100%; */
	 color: #313131;
   margin: 0;
}
 .grid-container .zone-1 .profile {
	 display: inline-flex;
	 margin-bottom: 5px;
	 margin-left: -15px;
	 width: 220px;
	 height: 220px;
	 border-radius: 50%;
	 /* background-image: url("https://image.freepik.com/free-photo/waist-up-portrait-handsome-serious-unshaven-male-keeps-hands-together-dressed-dark-blue-shirt-has-talk-with-interlocutor-stands-against-white-wall-self-confident-man-freelancer_273609-16320.jpg"); */
	 background-position: center top;
	 background-size: 200%;
	 border: 4px solid #2c2b29;
}
 .grid-container .zone-1 .contact-box {
	 margin-top: 10px;
}
 .grid-container .zone-1 .contact-box > * {
	 /* width: 100%; */
	 /* display: grid; */
	 /* grid-template-columns: 0.3fr 1fr; */
	 margin-top: 25px;
	 align-items: center;
}
 .grid-container .zone-1 .contact-box > * i {
	 font-size: 1.3em;
}
 .grid-container .zone-1 .contact-box > * .text {
	 display: inline-flex;
	 word-break: break-all;
}
 .grid-container .zone-1 .personal-box {
	 margin-top: 35px;
}
 .grid-container .zone-1 .personal-box > *:not(.title) {
	 margin: 25px 0px;
}
 .grid-container .zone-1 .personal-box .progress .dot {
	 display: inline-block;
	 width: 10px;
	 height: 10px;
	 background-color: #313131;
	 border-radius: 50%;
	 margin-left: 4px;
}
 .grid-container .zone-1 .personal-box .progress .dot.active {
	 background-color: #9db858;
}
 .grid-container .zone-1 .hobbies-box {
	 margin-top: 35px;
}
 .grid-container .zone-1 .hobbies-box .logo {
	 margin: 10px 0px;
	 font-size: 2.8em;
}
 .grid-container .zone-2 {
	 background: #2c2b29;
   float:left;
   width:109mm;
	 min-height: 297mm;
	 max-height: 297mm;
	 padding: 40px 20px;
	 padding-right: -10mm;
	 color: #b5b5b4;
}
 .grid-container .zone-2 .headTitle {
	 font-size: 2.1em;
	 color: #9db858;
}
 .grid-container .zone-2 .headTitle h1 {
	 font-weight: 400 !important;
}
 .grid-container .zone-2 .subTitle h1 {
	 font-weight: 400 !important;
}
 .grid-container .zone-2 .box {
	 display: inline-block;
	 padding: 2px 0px 2px 20px;
	 margin-left: -20px;
	 margin-top: 35px;
	 background: #9db858;
	 color: #2c2b29;
}
 .grid-container .zone-2 .group-1 .desc {
	 margin-top: 15px;
	 line-height: 1.5;
}
 .grid-container .zone-2 .group-2 .desc {
	 margin-top: 15px;
	 margin-left: 20px;
}
 .grid-container .zone-2 .group-2 .desc ul {
	 position: relative;
	 margin-top: 20px;
	 margin-left: 5px;
}
 .grid-container .zone-2 .group-2 .desc ul:before {
	 content: "";
	 position: absolute;
	 top: 12px;
	 left: -22px;
	 width: 10px;
	 height: 10px;
	 border-radius: 50%;
	 background: #9db858;
}
 .grid-container .zone-2 .group-2 .desc ul li {
	 list-style-type: none;
	 position: relative;
}
 .grid-container .zone-2 .group-2 .desc ul li:before {
	 content: "";
	 position: absolute;
	 top: 12px;
	 left: -18px;
	 height: 60px;
	 border-left: 2px solid #9db858;
}
 .grid-container .zone-2 .group-2 .desc ul:last-of-type li:before {
	 content: none;
}
 .grid-container .zone-2 .group-2 .desc ul li div:last-of-type {
	 color: #9db858;
	 font-weight: bold;
}
 .grid-container .zone-2 .group-3 .desc {
	 margin-top: 15px;
	 margin-left: 20px;
}
 .grid-container .zone-2 .group-3 .desc ul {
	 position: relative;
	 margin-top: 20px;
	 margin-left: 5px;
}
 .grid-container .zone-2 .group-3 .desc ul:before {
	 content: "";
	 position: absolute;
	 top: 30px;
	 left: -22px;
	 width: 10px;
	 height: 10px;
	 border-radius: 50%;
	 background: #9db858;
}
 .grid-container .zone-2 .group-3 .desc ul li {
	 list-style-type: none;
	 position: relative;
}
 .grid-container .zone-2 .group-3 .desc ul li:before {
	 content: "";
	 position: absolute;
	 top: 30px;
	 left: -18px;
	 height: 100px;
	 border-left: 2px solid #9db858;
}
 .grid-container .zone-2 .group-3 .desc ul:last-of-type li:before {
	 content: none;
}
 .grid-container .zone-2 .group-3 .desc ul li div:nth-child(2) {
	 color: #9db858;
	 font-weight: bold;
}
  
</style>
</head>
<body>

<!-- <a href="/pdf">pdf</a> -->
<div class="grid-container">
	<div class="zone-1">
		<div class="toCenter">
			<div class="profile"></div>
		</div>
		<div class="contact-box">
			<div class="title">
				<h2>Contact</h2>
			</div>
			<div class="call"><i class="fas fa-phone-alt"></i>
				<div class="text">{{$user->personalInfo->phone_no}}</div>
			</div>
			<div class="home"><i class="fas fa-home"></i>
				<div class="text">{{$user->personalInfo->contry}}</div>
			</div>
			<div class="email"><i class="fas fa-envelope"></i>
				<div class="text">{{$user->email}}</div>
			</div>
		</div>
		<div class="personal-box">
			<div class="title">
				<h2>Personal Skills</h2>
			</div>
      @foreach($user->skills as $skill)
			<div class="skill-1">
				<p>{{$skill->name}}</p>
				<div class="progress">
					<div class="dot active"></div>
					<div class="dot active"></div>
					<div class="dot active"></div>
					<div class="dot active"></div>
					<div class="dot active"></div>
					<div class="dot active"></div>
					<div class="dot active"></div>
				</div>
			</div>
      @endforeach
		</div>
	</div>
	<div class="zone-2">
		<div class="headTitle">
			<h1>{{$user->personalInfo->first_name}}<br><b>{{$user->personalInfo->last_name}}</b></h1>
		</div>
		<div class="subTitle">
			<h1><h1>
		</div>
		<div class="group-1">
			<div class="title">
				<div class="box">
					<h2>About Me</h2>
				</div>
			</div>
			<div class="desc">{{$user->personalInfo->about}}</div>
		</div>
		<div class="group-2">
			<div class="title">
				<div class="box">
					<h2>Work Experience</h2>
				</div>
			</div>
			<div class="desc">
      @foreach($user->jobExperience as $experince)
				<ul>
					<li>
						<div class="msg-1">{{(Carbon\Carbon::parse($experince->start_date))->format('F Y')}} - {{(Carbon\Carbon::parse($experince->end_date))->format('F Y')}} | {{$experince->country->name}}</div>
						<div class="msg-2">{{$experince->jobSubCategory->name}}</div>
					</li>
				</ul>
      @endforeach
			</div>
		</div>
		<div class="group-3">
			<div class="title">
				<div class="box">
					<h2>Education</h2>
				</div>
			</div>
			<div class="desc">
      @foreach($user->education as $education)
				<ul>
					<li>
						<div class="msg-1">{{$education->school}}</div>
						<div class="msg-2">{{$education->course_name}}, {{$education->field_of_study}}</div>
						<div class="msg-3">{{(Carbon\Carbon::parse($education->start_date))->format('F Y')}} | {{(Carbon\Carbon::parse($education->end_date))->format('F Y')}}</div>
					</li>
				</ul>
      @endforeach
			</div>
		</div>
    <div class="group-3">
			<div class="title">
				<div class="box">
					<h2>Certificates</h2>
				</div>
			</div>
			<div class="desc">
      @foreach($user->certificates as $certificate)
				<ul>
					<li>
						<div class="msg-1">{{$education->school}}</div>
						<div class="msg-2">{{$education->course_name}}, {{$education->field_of_study}}</div>
						<div class="msg-3">{{(Carbon\Carbon::parse($certificate->start_date))->format('F Y')}} | {{(Carbon\Carbon::parse($certificate->end_date))->format('F Y')}}</div>
					</li>
				</ul>
      @endforeach
			</div>
		</div>
    <div class="group-3">
			<div class="title">
				<div class="box">
					<h2>Licences</h2>
				</div>
			</div>
			<div class="desc">
      {{--@foreach($user->licences as $licence)
				<ul>
					<li>
						<div class="msg-1"></div>
						<div class="msg-2"></div>
						<div class="msg-3"></div>
					</li>
				</ul>
      @endforeach--}}
			</div>
		</div>
	</div>
</div>
</body>
</html>
