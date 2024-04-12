/*function nextPage() {
    // Get the selected degree choice
    var selectedDegree = document.querySelector('input[name="degree"]:checked');
  
    // Check if a degree choice is selected
    if (selectedDegree) {
      // Store the selected degree choice in local storage
      localStorage.setItem('selectedDegree', selectedDegree.value);
  
      // Redirect to qn2.html
      window.location.href = 'qn2.html';
    } else {
      // Alert the user to select a degree choice
      alert('Please select a degree choice.');
    }
  }
 */
/*Question
function nextPage() {
    var selectedOptions = document.querySelectorAll('input[name="degree"]:checked');
    if(selectedOptions.length > 0) {
      var selectedValues = [];
      selectedOptions.forEach(function(option) {
        selectedValues.push(option.value);
      });
      sessionStorage.setItem('degrees', JSON.stringify(selectedValues));
      window.location.href = "q2.html"; // Redirect to q2.html
    } else {
      alert("Please select at least one option.");
    }
  }*/
  

  function nextQuestion(nextPage) {
    // Here, you can optionally store user responses if needed
    
    // Redirect to the next question's HTML file
    window.location.href = nextPage;
  }
  