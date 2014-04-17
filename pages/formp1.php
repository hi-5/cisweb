<!--
  - This page is included from form.php. It
  - is only displayed when registering for the
  - first time. Clicking Next>> at the bottom
  - redirects the athlete to the information
  - form.
  -
  - File: formp1.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<div class="row">
  <div class="col-md-2">
    <img src="images/letterhead.png" />
  </div>
  <div class="col-md-10">
    <h4>Student-Athlete Acknowledgement and Consent Form<br />Step 1 of 2</h4>
  </div>
</div>

<br />

<form role="form" method="post">

  <!-- regulation message -->
  <div class="alert alert-danger">
    Participation within Canadian Interuniversity Sport (CIS) is a privilege that 
    requires full compliance with CIS regulations, including CIS Eligibility, 
    Athletic Financial Awards, and Doping Education &amp; Control Regulations. 
    Student-athletes are responsible for obtaining these regulations from their 
    coaches and/or Athletic Department and to inquire how their respective 
    circumstances relates to each. A copy is also available at 
    <a href="http://www.cis-sic.ca">www.cis-sic.ca</a>.
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">Eligibility and Athletic Financial Award Requirements for Student-Athletes</div>
    <div class="panel-body">
      It is critical that student-athletes farmiliarize themselves with the CIS Policies and Procedures entitled "Eligibility" and "Athletic Financial Awards". Student-athletes are responsible for obtaining these rules from their coaches and/or Athletic Department and to inquire how their respective circumstances relates to CIS eligibility and athletic financial aware requirements. This is important, as student-athletes need to be aware that those who participate in CIS competition and are found to be in violation of CIS Rules, may among other sanctions, forgeit their eligibiity for the remainder of the current competitive year and subsequent years.
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">Anti-Doping Regulations</div>
    <div class="panel-body">
      CIS is unequivocally opposed to any doping practices by student-athletes or by individuals in positions of leadership in amateur sport (i.e. coaches, medical practitioners, sport scientists, administrators, team managers, etc.). This not only includes presence of a World Anti-Doping Agency (WADA) Prohibited Substance or its Metabolites or Markers in an Athlete's bodily Sample, but also:<br />
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-asterisk"></span> Use or attempted use;</li>
            <li><span class="glyphicon glyphicon-asterisk"></span> Refusing or evading;</li>
            <li><span class="glyphicon glyphicon-asterisk"></span> Athlete availability, whereabouts information and missed tests;</li>
          </ul>
        </div>
        <div class="col-md-5">
          <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-asterisk"></span> Tampering or attempted tampering with any part of doping control;</li>
            <li><span class="glyphicon glyphicon-asterisk"></span> Possession of prohibited substances and methods;</li>
            <li><span class="glyphicon glyphicon-asterisk"></span> Trafficking or attempted trafficking;</li>
            <li><span class="glyphicon glyphicon-asterisk"></span> Administration or attempted administration.</li>
          </ul>
        </div>
      </div>
      Every athelete who participates in CIS training or competition is subject to doping control. Each CIS athlete is required to sign the "CIS Athlete Acknowledgement and Consent Form (AAC)" indicating their understanding of, and adherence to, CIS Anti-Doping Policy, and which includes their consent to doping control for a period of 18 months as of the date of signing. Failure to complete and sign the AAC form may result in an athlete's ineligibility for participation in any CIS program(s) but will not preclude doping control if the athlete has participated in any CIS training or competition. Sanctions for anti-doping rule violations are as specified in the CADP (available at <a href="http://www.cces.ca">www.cces.ca</a>), except as modified by CIS Policy (available at <a href="http://www.cis-sic.ca">www.cis-sic.ca</a>).
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">Collection, Use and Disclosure of Information</div>
    <div class="panel-body">
      In consideration of being permitted to participate in Canadian Interuniversity Sport, student-athletes allow CIS to:<br />
      <div class="row">
        <div class="col-md-1">
          <span class="glyphicon glyphicon-asterisk"></span>
        </div>
        <div class="col-md-11">
          disclose their personal information, including telephone number(s) and address(es), to the Canadian Centre for Ethics in Sport for its use in the conduct of the CIS Doping Control Program;
        </div>
      </div>
      <div class="row">
        <div class="col-md-1">
          <span class="glyphicon glyphicon-asterisk"></span>
        </div>
        <div class="col-md-11">
          use and disclose the information on the Athlete Registration Form and the Eligibility Certificate as well as their photograph and information about their athletic performances for promotional purposes which, as defined by the CIS Board of Directors, are in the best interest of the student-athlete or in the best interest of the public;
        </div>
      </div>
      <br />
      As part of its developmental and promotional pathnerships with professional and national sport organizations, CIS will also disclose from time to time, telephone numbers and addresses only of current CIS student-athletes to such other organizations involved in the recruitment and drafting of athletes.<br /><br />
      Subject to the following paragraph, I understand that by providing the personal information requested in the Student-Athlete Registration Form and the Eligibility Certificate (hereinafter "my Personal Information") I am consenting to such information being used and disclosed in the manner provided for above. I also understand that CIS is responsible only for information that is in its custody or control and that any information collected, used or disclosed by or under the control of a member of CIS or any other organization is subject to the privacy practices and procedures of that member or organization, as the case may be.
    </div>
  </div>

  <div class="well">
    By clicking next, I acknowledge that I have read, understood and will abide by Canadian Interuniversity Sport Eligibility, Athletic Financial Awards, and Doping Control Regulations. I also acknowledge having read CIS' Personal Information Protection Policy and understand the contents thereof.
  </div>

  <!-- new row -->
  <div class='row'>
    <div class="col-md-10"></div>
    <div class="col-md-2">
      <?php 
        echo "<a href='/?p=form&t=reg&s=2&i=" . $_SESSION['studentId'] . "' class='btn btn-lg btn-primary btn-block'>Next &raquo</a>";
      ?>
    </div>
  </div>

</form>

<br /><br />