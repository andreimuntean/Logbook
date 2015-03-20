// Global utility scripts go here.

var logbookIDCounter = 0;     // Keeps track of the id number given to logbooks.
var idCounter = 0;            // Keeps track of the id number given to logbook entries.
var logbooks = [];            // This keeps an array of every logbook created so far.
var createNewLogbook = false; // Decides whether or not to create a new logbook when saving.
var currentLogbookID = 0;
var logbookFocus = -1;         // Contains the id of the logbook the user has selected currently.

function searchLogbooks(token){
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "token":token,
                "action":"search"
            }
    }).done(function(response){
      console.log(response);
      //response - is the json format you need
      // the url format should be logbook.php?logbook=21
    })
}

function searchUsers(token){
    $.ajax({
            url:"inc/functions.php",
            type:"post",
            data:{
                "token":token,
                "action":"search"
            }
    }).done(function(response){
      console.log(response);
      //response - is the json format you need
      // the url format should be logbook.php?user=21
    })
}

function addLogbookToDB(logbookName, logbookPrivacy){
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "name":logbookName,
                "privacy":logbookPrivacy,
                "action":"new"
            }
    }).done(function(response){
       response = response.trim();
        createLogbook(logbookName, response)
        window.currentLogbookID =response;
    })
}

function deleteLogbookfromDB(logbookID){
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "id":logbookID,
                "action":"delete"
            }
    }).done(function(response){
       response = response.trim();
            console.log(response);
    })
}

function saveEntryToDB(currentLogbookID, content){
var entryID = 0;
if($("#currentTextArea").attr("edited") == "true"){
 entryID = $("#currentTextArea").attr("data-id");
}
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "id":currentLogbookID,
                "content": content,
                "editOF" : entryID,
                "action":"newEntry"
            }
    }).done(function(response){
       response = response.trim();
      //id of new created log entry
      $(".logbookContainer[id=" + response + "]").children(".logbookButton").click();
    })
}



// Creates a logbook and settings button in the left selection pane.
function createLogbook (logbookName, logbookID)
{
  var logbookDiv      = document.createElement ("div");
  var logbookButton   = document.createElement ("button");
  var settingsButton  = document.createElement ("button");

  // Creates the container div for the logbook and settings button.
  logbookDiv.setAttribute ("class", "logbookContainer");
  logbookDiv.id = logbookID;
  document.getElementById("logbookSelectionPane").appendChild (logbookDiv);

  // Creates the logbook button and adds it to the new div.
  logbookButton.setAttribute ("class", "logbookButton");
  logbookButton.setAttribute ("type", "button");

  // Creates a trailing name if name length is too long.
  if (logbookName.length > 15) {
    logbookName = logbookName.substr(0, 15) + '...';
  }
  logbookButton.innerHTML = logbookName;
  document.getElementById(logbookID).appendChild (logbookButton);

  // Creates the logbook settings button and adds it as well.
  settingsButton.setAttribute ("class", "settingsButton");
  settingsButton.setAttribute ("type", "button");
  settingsButton.onclick = partial (openLogbookSettings, logbookID);
  document.getElementById(logbookID).appendChild (settingsButton);

  // Sets the logbook focus to this logbook and enables the create entry button.
  changeLogbookFocus (logbookID);

  // logbookIDCounter is incremented (guarantees each entry id is unique).
  logbookIDCounter++;
}

// Creates a logbook entry in the right editor pane.
function createLogbookEntry ()
{
  if($("#currentTextArea").length )
    return false;
  if(window.currentLogbookID == 0){
    $.notify("Choose a logbook first", "warn");
    return false;
  }
 // document.getElementById("createLogbookEntryButton").setAttribute("disabled", "disabled");
  var editArray = document.getElementsByClassName("editButton");
  for (var editInstance = 0; editInstance < editArray.length; editInstance++)
  {
    editArray[editInstance].removeAttribute("onclick");
    editArray[editInstance].setAttribute("style", "color: #9B9EA2");
  }

  var entryDiv      = document.createElement ("div");
  var entryHeader   = document.createElement ("div");
  var entryContent  = document.createElement ("div");
  var entryID       = "entry" + idCounter;
  var entryTextArea = document.createElement ("textarea");
  var saveEntry     = document.createElement ("span");

  // Creates the container div and sets its id so the other divs can be placed
  // inside.
  entryDiv.setAttribute ("class", "entryContainer");
  entryDiv.id = entryID;
  document.getElementById("logbookEditorSpace").appendChild (entryDiv);

  // Adds the inner divs inside of the new container div.
  entryHeader.setAttribute ("class", "entryHeader");
  entryHeader.innerHTML = "More test text";

  entryContent.setAttribute ("class", "entryContent");
  document.getElementById(entryID).appendChild (entryHeader);
  entryHeader.id = entryID + "H";
  document.getElementById(entryID).appendChild (entryContent);
  entryContent.id = entryID + "C";

  entryTextArea.setAttribute ("class", "entryTextArea");
  entryTextArea.id = "currentTextArea";
  saveEntry.setAttribute ("class", "saveButton");
  saveEntry.id = "currentSaveButton";
  saveEntry.setAttribute ("onclick", "saveEntry()");

  entryHeader.appendChild (saveEntry);
  entryContent.appendChild (entryTextArea);
  tinyMCE.remove();
  tinyMCE.init({
   mode: "textareas",
   selector: "textarea"
  });
  saveEntry.innerHTML = "Save";
  // idCounter is incremented (guarantees each entry id is unique).
  idCounter++;
}

function saveEntry ()
{
  tinymce.triggerSave();
  saveEntryToDB(window.currentLogbookID, $("#currentTextArea").val());
  tinymce.remove();

  $("#currentTextArea").removeAttr("edited");
  $("#currentTextArea").hide();
  $(".logbookContainer#" + window.currentLogbookID).children(".logbookButton").click();

  // Re-enable the create log button.
  //document.getElementById("createLogbookEntryButton").removeAttribute ("disabled");

  // Add the date an time tag.
  //textToSave = "<span style=\"color: #FFFFFF\">[" + date + "]</span>" + "<br>" + textToSave;
}

function editEntry (buttonId)
{
  console.log(buttonId);
  //document.getElementById("createLogbookEntryButton").disabled = true;
  var editArray = document.getElementsByClassName("editButton");
  for (var editInstance = 0; editInstance < editArray.length; editInstance++)
  {
    editArray[editInstance].removeAttribute("onclick");
    editArray[editInstance].setAttribute("style", "color: #9B9EA2");
  }

  var entryTextArea = document.createElement ("textarea");
  var saveEntry     = document.createElement ("span");
  var editEntry     = document.getElementById(buttonId);
  var databaseID    = buttonId.substring(5, buttonId.length - 1)
  entryTextArea.setAttribute ("class", "entryTextArea");
  entryTextArea.setAttribute ("data-id", databaseID);
  entryTextArea.id = "currentTextArea";
  saveEntry.setAttribute ("class", "saveButton");
  saveEntry.id = "currentSaveButton";
  saveEntry.setAttribute ("onclick", "saveEntry()");

  // Replacing edit with save.
  editEntry.remove();
  var entryHeaderID = buttonId.substring(0, buttonId.length - 1) + "H";
  document.getElementById(entryHeaderID).appendChild (saveEntry);
  saveEntry.innerHTML = "Save";

  // Adding the text area.
  var entryContentID = buttonId.substring(0, buttonId.length - 1) + "C";
  var oldContent = $("#" + entryContentID).html();
  $("#" + entryContentID).html("");
   document.getElementById(entryContentID).appendChild (entryTextArea);
   entryTextArea.innerHTML = oldContent;
   $("#currentTextArea").attr("edited","true");
  tinyMCE.remove();
  tinyMCE.init({
   mode: "textareas",
   selector: "textarea"
  });
}

// This function generates a log so that it can be pulled from the server.
function generatePulledLog(textToSave)
{
  var entryDiv      = document.createElement ("div");
  var entryHeader   = document.createElement ("div");
  var entryContent  = document.createElement ("div");
  var entryID       = "entry" + idCounter;
  var editEntry    = document.createElement("span");
  var sectionBreak = document.createElement("hr");

  // Creates the container div and sets its id so the other divs can be placed
  // inside.
  entryDiv.setAttribute ("class", "entryContainer");
  entryDiv.id = entryID;
  document.getElementById("logbookEditorSpace").appendChild (entryDiv);

  // Adds the inner divs inside of the new container div.
  entryHeader.setAttribute ("class", "entryHeader");
  entryHeader.innerHTML = "More test text";

  entryContent.setAttribute ("class", "entryContent");
  document.getElementById(entryID).appendChild (entryHeader);
  entryHeader.id = entryID + "H";
  document.getElementById(entryID).appendChild (entryContent);
  entryContent.id = entryID + "C";

  // Create an edit button.
  entryHeader.appendChild(editEntry);
  editEntry.id = editEntry.parentNode.parentNode.id + "E";
  editEntry.setAttribute("onclick", "editEntry(this.id)");
  editEntry.setAttribute("class", "editButton");
  editEntry.innerHTML = "Edit";

  entryContent.innerHTML = textToSave;
  entryContent.appendChild(sectionBreak);

  idCounter++;
}

// Opens the logbook settings popup.
function togglePopUp (isOn, id)
{
  var display = "";
  if (isOn) {
    display = 'block';
  } else {
    display = 'none'
  }

  document.getElementById(id).style.display = display;
  document.getElementById("blanket").style.display = display;
  
}

// Saves the desired settings for a logbook.
function saveLogbookSettings ()
{
  togglePopUp (false, 'settings')
  // If true, a logbook is created with these
  if (createNewLogbook)
  {
    createNewLogbook = false;
    name = $("#logbookName").val();
    $("#logbookName").val("");
    privacy = $("#visibility").val();
    addLogbookToDB(name, privacy);
    location.href = "home.php";
  }
}

// Cancels logbook creation or removes a logbook from the user's logbooks.
function deleteLogbook ()
{
	togglePopUp (false, 'settings')
	// If false, the logbook is a preexisting one and must be removed.
	if (!createNewLogbook)
	{
    deleteLogbookfromDB(currentLogbookID);
		var logbookToDelete = document.getElementById (currentLogbookID);
		document.getElementById ("logbookSelectionPane").removeChild (logbookToDelete)
    document.getElementById("createLogbookEntryButton").disabled = true;
    tinyMCE.remove();
    $(".entryContainer").remove();
    changeLogbookFocus (-1);
	}
}

// Toggles the logbook settings popup on AND sets the currentLogbookID.
function openLogbookSettings (logbookID)
{
	togglePopUp (true, 'settings');
	currentLogbookID = logbookID;
}

// Switches focus to a new logbook
function changeLogbookFocus (newLogbookID)
{
  if (document.getElementById(logbookFocus) != null) {
    document.getElementById(logbookFocus).childNodes[0].style.backgroundColor = "#393F48";
  }
  logbookFocus = newLogbookID;
  if (document.getElementById(logbookFocus) != null) {
    document.getElementById(logbookFocus).childNodes[0].style.backgroundColor = "#9B9EA2";
  }
}

/* Code taken from: 'http://blog.dreasgrech.com/2009/11/passing-pointer-to-functi
 * on-with.html'. It allows a function reference to be passed with parameters.*/
var partial = function (func /*, 0..n args */) {
  var args = Array.prototype.slice.call(arguments, 1);
  return function () {
      var allArguments = args.concat(Array.prototype.slice.call(arguments));
      return func.apply(this, allArguments);
  }
}

$(document).ready(function(){
  //$(".logbookEditor").niceScroll({ autohidemode: true })
  //$(".logbookSelectionPane").niceScroll({ autohidemode: true })
  //global variable currentLogbookID

function savePassword(){
  var password = $("#profilePassword").val();
  if (password == "")
    return false;
   $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "password":password,
                "action":"password"
            }
    }).done(function(response){
      $("#profilePassword").val("");
      $.notify("Password successfully changed", "success");
    })

}
$("#saveButton").click(function(e){
  e.preventDefault();
  savePassword();
})
  window.currentLogbookID = 0;
	$("#signUpButton").click(function(){
		var username = $("input[name='username']").val();
		var email = $("input[name='email']").val();
		var password = $("input[name='password']").val();

		if(username.length == 0 || email.length == 0 || password.length == 0){
			$.notify("Please fill all required fields", "warn")
			return false;
		}
		if(password.length > 15 || password.length < 5){
			$.notify("Password length must be between 5 and 15", "warn");
			return false;
		}
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 		if(!regex.test(email)){
 			$.notify("Email is not valid", "warn");
 			return false
 		}
 		regex = /^([a-zA-Z0-9_.])/;
 		if(!regex.test(username)){
 			$.notify("Username is not valid", "warn");
 			return false;
 		}

 		$.ajax({
 			url:"inc/register.php",
 			type:"post",
 			data:{
 				"username":username,
 				"email":email,
 				"password":password
 			}
 		})
 		.done(function(response){
 			response = response.trim();
 			if(response == "-1"){
 				$.notify("Something unforseen has happened", "error");
 			}else if(response == "-2"){
				$.notify("Email is already in use", "warn");
 			}else if(response == "-3"){
				$.notify("Username is already in use", "warn");
 			}else if(parseInt(response) > 0){
				$.notify("Successfully registered, redirecting...", "success");
				setTimeout(function(){
					location.href = "home.php";
				}, 2000);
 			}else{
 				console.log(response);
 			}
 		})
	})

	//logout
	$("#sign-out-button").click(function(){
		$.ajax({
 			url:"inc/login.php",
 			type:"post",
 			data:{
 				"logout":"1"
 			}
 		}).done(function(response){
 			$.notify("Bye!", "success");
 			setTimeout(function(){
 				location.href = "index.php";
 			}, 1000)
 		})
	})

  $("#sign-in-button").click(function(){
    $.ajax({
      url:"inc/login.php",
      type:"post",
      data:{
        "username":$("#sign-in-username").val(),
        "password":$("#sign-in-password").val()
      }
    }).done(function(response){
      response = response.trim();
      console.log(response);
      if(response == "0")
        $.notify("Wrong username and password combination", "alert");
      else
      {
        $.notify("Successfully logged in", "success");
        setTimeout(function(){
          location.href = "home.php";
        }, 500)
      }
    })
  })

  // Handler for when logbook button is clicked
  $(".logbookButton").click(function(){
    if ($(this).attr("id") != "createLogbookButton") {
      var logbookID = $(this).parent().attr("id");
      changeLogbookFocus (logbookID);
      if(!$.isNumeric(logbookID))
        return false;
      window.currentLogbookID = logbookID;
       $.ajax({
              url:"inc/logbook.php",
              type:"post",
              data:{
                  "id":logbookID,
                  "action":"showAllEntries"
              }
      }).done(function(response){
        $("#logbookEditorSpace").html(response);
      })
    }})

  // Handler for changing the user's profile picture
  $("#upload-profile-pic").change(function() {
    // The file and formdata is obtained
    var file = document.getElementById("upload-profile-pic").files[0];
    var formData = new FormData();
    formData.append("image", file);
    // Picture must pass each of the validation steps.
    var val = $("#upload-profile-pic").val();
    if (!val.match(/(?:gif|jpg|png|jpeg)$/)) {
      // inputted file path is not an image of one of the above types
      alert("Image file must be of either GIF, JPG, PNG or JPEG formats");
    } else if (this.files[0].size > 1000000) {
      alert("Image file size must be less than 1MB");
    } else {
      // If validation is successful, image is stored.
      $.ajax({
        type:"post",
        url:"inc/profilePicUpload.inc.php",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(res) { $.notify("Profile picture successfuly changed", 'success'); setTimeout(function(){location.href="home.php"}, 500);}
      });
    }
  });
})
