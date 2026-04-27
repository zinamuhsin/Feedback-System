<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; padding: 40px 0; }
        .feedback-container {
            background: white; border-radius: 15px; padding: 40px;
            max-width: 700px; margin: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
       
        .header-title { color: #6200ee; font-weight: bold; margin-bottom: 30px; font-size: 24px; text-align: center; text-transform: uppercase; }
        
        .form-label { font-weight: 600; color: #333; margin-top: 15px; font-size: 14px; }
        
        .rating-wrapper { display: flex; justify-content: space-between; margin-top: 10px; gap: 5px; }
        .rating-btn { 
            flex: 1; height: 40px; border: 1px solid #dee2e6; background: white;
            display: flex; align-items: center; justify-content: center; 
            cursor: pointer; border-radius: 4px; font-size: 13px;
        }
        .rating-btn.active { background-color: #6200ee; color: white; border-color: #6200ee; }

        .emoji-item { cursor: pointer; opacity: 0.4; filter: grayscale(100%); transition: 0.3s; font-size: 30px; }
        .emoji-item.active { opacity: 1; filter: grayscale(0%); transform: scale(1.2); }
        
        .submit-btn { background-color: #6200ee; color: white; padding: 12px; width: 100%; border: none; border-radius: 6px; font-weight: bold; margin-top: 30px; }
        
        .result-card { background: #fff; padding: 15px; border-radius: 8px; border-left: 5px solid #6200ee; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container">
    <div class="feedback-container">
        <h4 class="header-title">Feedback Form</h4>
        
        <form id="feedbackForm">
            <label class="form-label">Your name</label>
            <input type="text" id="name" class="form-control" placeholder="e.g. Zina Muhsin" required>

            <label class="form-label">Your email address</label>
            <input type="email" id="email" class="form-control" placeholder="example@mail.com" required>

            <label class="form-label">Phone number</label>
            <div class="input-group">
                <span class="input-group-text bg-white">🇮🇶 +964</span>
                <input type="text" id="phone" class="form-control" placeholder="750 XXX XXXX">
            </div>

            <label class="form-label">How satisfied are you with the usability?</label>
            <div class="rating-wrapper" id="usabilityRating"></div>
            <input type="hidden" id="ratingVal" value="10">

            <label class="form-label">Did you encounter any issues or bugs? If yes, please explain</label>
            <input type="text" id="bugs" class="form-control" placeholder="Describe issues here">

            <label class="form-label">How easy is it to navigate through?</label>
            <div class="rating-wrapper" id="navRating"></div>
            <input type="hidden" id="navVal" value="10">

            <label class="form-label">What improvements would you like to see?</label>
            <textarea id="message" class="form-control" rows="3" placeholder="Write your feedback here..." required></textarea>

            <label class="form-label">Overall experience?</label>
            <div class="d-flex gap-3 mt-2">
                <span class="emoji-item" onclick="setEmoji(this, '😠')">😠</span>
                <span class="emoji-item" onclick="setEmoji(this, '🙁')">🙁</span>
                <span class="emoji-item" onclick="setEmoji(this, '😐')">😐</span>
                <span class="emoji-item" onclick="setEmoji(this, '😊')">😊</span>
                <span class="emoji-item active" onclick="setEmoji(this, '😍')">😍</span>
            </div>
            <input type="hidden" id="selectedEmoji" value="😍">

            <label class="form-label d-block">Will you recommend this to others?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="recommend" id="yes" value="Yes" checked>
                <label class="form-check-label" for="yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="recommend" id="no" value="No">
                <label class="form-check-label" for="no">No</label>
            </div>

            <button type="submit" class="submit-btn shadow">SUBMIT FEEDBACK</button>
        </form>
    </div>

    <div class="mt-5 mx-auto" style="max-width: 700px;">
        <h5 class="fw-bold mb-4 text-secondary">SUBMITTED RESULTS</h5>
        <div id="resultsList"></div>
    </div>
</div>

<script>
    
    function createRating(containerId, hiddenId) {
        const container = document.getElementById(containerId);
        for (let i = 1; i <= 10; i++) {
            let div = document.createElement('div');
            div.className = 'rating-btn' + (i === 10 ? ' active' : '');
            div.innerText = i;
            div.onclick = function() {
                container.querySelectorAll('.rating-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(hiddenId).value = i;
            };
            container.appendChild(div);
        }
    }
    createRating('usabilityRating', 'ratingVal');
    createRating('navRating', 'navVal');

    
    function setEmoji(el, emoji) {
        document.querySelectorAll('.emoji-item').forEach(e => e.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('selectedEmoji').value = emoji;
    }

   
    function loadResults() {
        fetch('get_feedback.php')
        .then(res => res.json())
        .then(data => {
            const list = document.getElementById('resultsList');
            list.innerHTML = ''; 
            data.forEach(item => {
                list.innerHTML += `
                    <div class="result-card">
                        <strong>${item.name}</strong> <span class="badge bg-light text-dark border ms-2">${item.subject}</span>
                        <p class="text-muted small mb-0 mt-2">${item.message}</p>
                    </div>`;
            });
        });
    }
    loadResults();

   
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let usability = document.getElementById('ratingVal').value;
        let emoji = document.getElementById('selectedEmoji').value;
        let combinedSubject = 'Rating: ' + usability + '/10 ' + emoji;

        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('subject', combinedSubject);
        formData.append('message', document.getElementById('message').value);

        fetch('add_feedback.php', { method: 'POST', body: formData })
        .then(() => {
            alert("ناردن سەرکەوتوو بوو!");
            this.reset();
            loadResults(); 
        });
    });
</script>
</body>
</html>