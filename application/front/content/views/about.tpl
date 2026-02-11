<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
        body {
            font-family: Arial, sans-serif;
        }
        .custom-image {
            height: 400px;
            object-fit: cover;
        }
        .profile-user-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            background-color: #f8e1d2;
            border-radius: 20px;
            padding: 20px;
        }
        .social-links a {
            color: #007bff;
            text-decoration: none;
            font-size: 2rem;
            margin: 0 10px;
        }
        .social-links a:hover {
            color: #0056b3;
        }
        .map-section {
            height: 300px;
        }
        .footer-links a {
            color: #6c757d;
            margin: 0 10px;
            text-decoration: none;
        }
        .footer-links a:hover {
            color: #000;
        }
        h4 {
            color: #000;
            font-weight: bold;
        }
        p {
            color: #000;
            font-size: large;
        }
        .mt-5 {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .card-body1 {
            width: 94%;
            border-radius: 43px;
            margin-left: 56px;
            background-color: #ddd6d6;
            padding: 20px;
            height: 238px;
        }
        .card {
            border: none;
            background-color: transparent;
            border-radius: 43px;
            margin-left: 56px;
            margin-right: 30px;
        }
        .avatar-preview {
            margin-left: 65px;
            margin-top: 17px;
            text-align: center;
            width: 30% !important;
            overflow: visible !important;
        }
        .card-deck .card {
            border: none;
            background-color: transparent;
        }
        .card-deck .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        .card-deck .card-body2 {
            padding: 10px;
            text-align: center;
        }
        .social-contact, .address-map {
            margin-left: 56px;
            margin-right: 44px;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
       .mt-3 {
            color: white;
            background-color: purple;
            border-radius: 12px;
            font-size: larger;
            padding-top: 2px;
            padding-bottom: 2px;
      }
      .card-title {
            color: purple;
      }
      .text-center {
            color: purple;
      }
      .social-contact {
            text-align: center;
      }
      .card-img-top{
            border-radius: 10px;
      }
      h4{
            margin-bottom: 20px;
      }

      .avatar-preview h3 {
            padding: 10px 0px;
      }

      .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 14px;
      }

      .card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }

      .modal-dialog {
            background: white;
            padding: 20px 10px;
      }
    </style>



<!-- Carousel Section  <pre><%$page_data|print_r%></pre>-->
<section class="about-dashboard">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item">
                  <img class="d-block w-100 custom-image" src="<%$sliderImage0%>" alt="Third slide">
            </div>
            <div class="carousel-item active">
                  <img class="d-block w-100 custom-image" src="<%$sliderImage1%>" alt="First slide">
            </div>
            <div class="carousel-item">
                  <img class="d-block w-100 custom-image" src="<%$sliderImage2%>" alt="Second slide">
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<!-- User Profile Section -->
<%if $profiletype eq 'my_profile'%>
<span>
      <a class="" href="<%$this->url->make('content/content/aboutform')%>?form-type=edit&user_id=<%$page_data[0]['iUserId']%>">
            <button type="button" class="btn btn-primary" style="float: right; background-color: #800080;border-color: #453029; margin: 10px 20px;">
                  Edit
            </button>
      </a>
</span>
<%/if%>
<section class="user-details mt-5 text-center">
    <div class="avatar-preview">
        <img class="profile-user-img rounded-circle" src="<%$userinfo['u_profile_image']%>" alt="Profile Picture">
        <h3 class="mt-3"><%$userinfo['u_name']%></h3>
    </div>
    <div class="" style="min-width: 1000px;">
        <div class="card-body1">
            <h4><%$page_data[0]['userQuestion']%></h4>
            <p><%$page_data[0]['userAnswer']%></p>
        </div>
    </div>
</section>

<!-- Important People Section -->

<section class="important-people my-5">
    <h4 class="text-center"><%$page_data[0]['importantPeopleTitle']%></h4>
    <div class="card-deck mx-5">
        <div class="card">
            <img class="card-img-top" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$page_data[0]['iUserId']%>/<%$page_data[0]['peopleOneImage']%>" alt="Person 1">
            <div class="card-body2">
                <h5 class="card-title"><%$page_data[0]['peopleOneTitle']%></h5>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$page_data[0]['iUserId']%>/<%$page_data[0]['peopleTwoImage']%>" alt="Person 2">
            <div class="card-body2">
                <h5 class="card-title"><%$page_data[0]['peopleTwoTitle']%></h5>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$page_data[0]['iUserId']%>/<%$page_data[0]['peopleThreeImage']%>" alt="Person 3">
            <div class="card-body2">
                <h5 class="card-title"><%$page_data[0]['peopleThreeTitle']%></h5>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$page_data[0]['iUserId']%>/<%$page_data[0]['peopleFourImage']%>" alt="Person 4">
            <div class="card-body2">
                <h5 class="card-title"><%$page_data[0]['peopleFourTitle']%></h5>
            </div>
        </div>
    </div>
</section>

<!-- Social Media and Contact Section -->
<section class="social-contact mx-5">
    <h4>Check me out on other social media platforms</h4>
    <div class="social-links">
        <a href="<%$page_data[0]['InstaUrl']%>"><i class="fab fa-instagram"></i></a>
        <a href="<%$page_data[0]['ytUrl']%>"><i class="fab fa-youtube"></i></a>
        <a href="<%$page_data[0]['linkedinUrl']%>"><i class="fab fa-linkedin"></i></a>
        <a href="<%$page_data[0]['xUrl']%>"><i class="fab fa-twitter"></i></a>
    </div>
    <p><strong>Phone:</strong> <%$page_data[0]['phoneNumber']%></p>
</section>

<!-- Address and Map Section -->
<section class="address-map mx-5 my-5">
    <h4>Visit my city</h4>
    <p><strong>Address:</strong> <%$page_data[0]['address']%></p>
    <div class="map-section">
        <iframe src="https://www.google.com/maps?q=<%urlencode($page_data[0]['address'])%>&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>


<!--Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method="post" action="<%$this->url->make('content/content/addUserPage')%>" enctype="multipart/form-data">
      <div class="container my-4">
            <h3 class="mb-3">Create Your Personal Portfolio Page </h3>
            <div class="form-group  mb-4">
                  <label for="whoAmITitle"><strong>Section Title</strong></label>
                  <input 
                  type="text" 
                  name="who_am_i_title"
                  value="<%$page_data[0]['userQuestion']%>"
                  class="form-control" 
                  id="whoAmITitle" 
                  placeholder="Enter a custom section title (e.g., Who Am I?)"
                  >
                  <small class="form-text text-muted">
                        You can change the section title to suit your question (e.g., “What Drives Me?”, “My Motivation?”).
                  </small>
            </div>
            <div class="form-group  mb-4">
                  <label for="whoAmIText"><strong>Your Question or Introduction</strong></label>
                  <textarea 
                  class="form-control" 
                  name="who_am_i_text"
                  id="whoAmIText" 
                  value="<%$page_data[0]['userAnswer']%>"
                  rows="4" 
                  placeholder="Write about yourself or ask your own question..."
                  ></textarea>
                  <small class="form-text text-muted">
                        This area is completely editable — use it to share your story, ask a question, or describe yourself.
                  </small>
            </div>
            <h3 class="mb-3">Add Important People</h3>
            <!-- Section Title Section -->
            <div class="form-group mb-4">
                  <label for="importantPeopleTitle" class="form-label fw-bold">Section Title for Important People</label>
                  <input 
                        type="text" 
                        name="important_people_title" 
                        class="form-control" 
                        value="<%$page_data[0]['importantPeopleTitle']%>"
                        id="importantPeopleTitle" 
                        placeholder="e.g., 'Key People in My Life' or 'Who Inspires Me?'" 
                        id="importantPeopleDesc"
                        aria-describedby="importantPeopleDesc"
                  >
                  <small id="text" id="form-control" class="mb-3">
                        Customize the title for this section to reflect your story, such as "My Mentors" or "Loved Ones Who Matter."
                  </small>
            </div>

            <!-- Existing Important People Section -->
            <div class="form-group mb-4">
                  <!-- Person 1 -->
                  <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="personName1" class="form-label fw-bold">Name of Person 1</label>
                        <input 
                              type="text" 
                              name="person_name_1" 
                              class="form-control" 
                              id="personName1" 
                              value="<%$page_data[0]['peopleOneTitle']%>"
                              placeholder="Enter their name" 
                              aria-describedby="personName1Help"
                        >
                        <small id="personName1Help" class="form-text text-muted">
                              Enter the full name or a nickname for this person.
                        </small>
                        </div>
                        <div class="col-md-6">
                        <label for="personImage1" class="form-label fw-bold">Upload Photo of Person 1</label>
                        <input 
                              type="file" 
                              name="person_image_1" 
                              class="form-control" 
                              id="personImage1" 
                              accept="image/*" 
                              aria-describedby="personImage1Help"
                        >
                        <small id="personImage1Help" class="form-text text-muted">
                              Upload a JPG, PNG, or other image file (max 5MB recommended).
                        </small>
                        </div>
                  </div>
                  <!-- Person 2 -->
                  <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="personName2" class="form-label fw-bold">Name of Person 2</label>
                        <input 
                              type="text" 
                              name="person_name_2" 
                              class="form-control" 
                              value="<%$page_data[0]['peopleTwoTitle']%>"
                              id="personName2" 
                              placeholder="Enter their name" 
                              aria-describedby="personName2Help"
                        >
                        <small id="personName2Help" class="form-text text-muted">
                              Enter the full name or a nickname for this person.
                        </small>
                        </div>
                        <div class="col-md-6">
                        <label for="personImage2" class="form-label fw-bold">Upload Photo of Person 2</label>
                        <input 
                              type="file" 
                              name="person_image_2" 
                              class="form-control" 
                              id="personImage2" 
                              accept="image/*" 
                              aria-describedby="personImage2Help"
                        >
                        <small id="personImage2Help" class="form-text text-muted">
                              Upload a JPG, PNG, or other image file (max 5MB recommended).
                        </small>
                        </div>
                  </div>
                  <!-- Person 3 -->
                  <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="personName3" class="form-label fw-bold">Name of Person 3</label>
                        <input 
                              type="text" 
                              name="person_name_3" 
                              class="form-control" 
                              value="<%$page_data[0]['peopleThreeTitle']%>"
                              id="personName3" 
                              placeholder="Enter their name" 
                              aria-describedby="personName3Help"
                        >
                        <small id="personName3Help" class="form-text text-muted">
                              Enter the full name or a nickname for this person.
                        </small>
                        </div>
                        <div class="col-md-6">
                        <label for="personImage3" class="form-label fw-bold">Upload Photo of Person 3</label>
                        <input 
                              type="file" 
                              name="person_image_3" 
                              class="form-control" 
                              id="personImage3" 
                              accept="image/*" 
                              aria-describedby="personImage3Help"
                        >
                        <small id="personImage3Help" class="form-text text-muted">
                              Upload a JPG, PNG, or other image file (max 5MB recommended).
                        </small>
                        </div>
                  </div>
                  <!-- Person 4 -->
                  <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="personName4" class="form-label fw-bold">Name of Person 4</label>
                        <input 
                              type="text" 
                              name="person_name_4" 
                              class="form-control" 
                              id="personName4" 
                              placeholder="Enter their name" 
                              value="<%$page_data[0]['peopleFourTitle']%>"
                              aria-describedby="personName4Help"
                        >
                        <small id="personName4Help" class="form-text text-muted">
                              Enter the full name or a nickname for this person.
                        </small>
                        </div>
                        <div class="col-md-6">
                        <label for="personImage4" class="form-label fw-bold">Upload Photo of Person 4</label>
                        <input 
                              type="file" 
                              name="person_image_4" 
                              class="form-control" 
                              id="personImage4" 
                              accept="image/*" 
                              aria-describedby="personImage4Help"
                        >
                        <small id="personImage4Help" class="form-text text-muted">
                              Upload a JPG, PNG, or other image file (max 5MB recommended).
                        </small>
                        </div>
                  </div>
            </div>
            <div class="form-group mb-4">
                  <h3 class="mb-3">Your Social Media & Contact Details</h3>
                  <div class="row mb-3">
                        <!-- Facebook -->
                        <div class="col-md-6 mb-3">
                        <label for="facebookLink" class="form-label fw-bold">Facebook Profile Link</label>
                        <input 
                              type="text" 
                              name="facebook_link" 
                              class="form-control" 
                              value="<%$page_data[0]['fbUrl']%>"
                              id="facebookLink" 
                              placeholder="e.g., https://www.facebook.com/username" 
                              aria-describedby="facebookLinkHelp"
                        >
                        <small id="facebookLinkHelp" class="form-text text-muted">
                              Paste the full URL to your Facebook profile (optional).
                        </small>
                        </div>
                        <!-- Instagram -->
                        <div class="col-md-6 mb-3">
                        <label for="instagramLink" class="form-label fw-bold">Instagram Profile Link</label>
                        <input 
                              type="text" 
                              name="instagram_link" 
                              class="form-control" 
                              id="InstagramLink"
                              value="<%$page_data[0]['InstaUrl']%>"
                              placeholder="e.g., https://www.instagram.com/username" 
                              aria-describedby="instagramLinkHelp"
                        >
                        <small id="instagramLinkHelp" class="form-text text-muted">
                              Paste the full URL to your Instagram profile (optional).
                        </small>
                        </div>
                  </div>
                  <div class="row mb-3">
                        <!-- YouTube -->
                        <div class="col-md-6 mb-3">
                        <label for="youtubeLink" class="form-label">YouTube Channel Link</label>
                        <input 
                              type="text" 
                              name="youtube_link" 
                              class="form-control" 
                              id="youtubeLink" 
                              value="<%$page_data[0]['ytUrl']%>"
                              placeholder="e.g., https://www.youtube.com/@username" 
                              aria-describedby="youtubeLinkHelp"
                        >
                        <small id="youtubeLinkHelp" class="form-text text-muted">
                              Paste the full URL to your YouTube channel (optional).
                        </small>
                        </div>
                        <!-- LinkedIn -->
                        <div class="col-md-6 mb-3">
                        <label for="linkedinLink" class="form-label fw-bold">LinkedIn Profile Link</label>
                        <input 
                              type="text" 
                              name="linkedin_link" 
                              class="form-control" 
                              value="<%$page_data[0]['linkedinUrl']%>"
                              id="linkedinLink" 
                              placeholder="e.g., https://www.linkedin.com/in/username" 
                              aria-describedby="linkedinLinkHelp"
                        >
                        <small id="linkedinLinkHelp" class="form-text text-muted">
                              Paste the full URL to your LinkedIn profile (optional).
                        </small>
                        </div>
                  </div>
                  <div class="row mb-3">
                        <!-- X -->
                        <div class="col-md-6 mb-3">
                        <label for="xLink" class="form-label fw-bold">X Profile Link</label>
                        <input 
                              type="text" 
                              name="x_link" 
                              class="form-control" 
                              value="<%$page_data[0]['xUrl']%>"
                              id="xLink" 
                              placeholder="e.g., https://x.com/username" 
                              aria-describedby="xLinkHelp"
                        >
                        <small id="xLinkHelp" class="form-text text-muted">
                              Paste the full URL to your X profile (optional).
                        </small>
                        </div>
                        <!-- Phone Number -->
                        <div class="col-md-6 mb-3">
                        <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                        <input 
                              type="tel" 
                              name="phone_number" 
                              class="form-control" 
                              value="<%$page_data[0]['phoneNumber']%>"
                              id="phoneNumber" 
                              placeholder="e.g., (123) 456-7890" 
                              aria-describedby="phoneNumberHelp"
                        >
                        <small id="phoneNumberHelp" class="form-text text-muted">
                              Enter your phone number in any standard format (optional).
                        </small>
                        </div>
                  </div>
                  <!-- Address -->
                  <div class="row mb-3">
                        <div class="col-md-12">
                        <label for="address" class="form-label fw-bold">Address</label>
                        <input 
                              type="text" 
                              name="address" 
                              class="form-control" 
                              value="<%$page_data[0]['address']%>"
                              id="address" 
                              placeholder="e.g., 1234 Sunshine Drive, Orlando, FL 32836" 
                              aria-describedby="addressHelp"
                        >
                        <small id="addressHelp" class="form-text text-muted">
                              Enter your full address, including street, city, state, and ZIP code (optional).
                        </small>
                        </div>
                  </div>
            </div>
      </div>
      <button type="submit" class="btn btn-primary mb-2">Let's Go ...</button>
      </form>
      </div>
</div>
