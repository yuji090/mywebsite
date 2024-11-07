<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - My Website</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section style="display: flex; justify-content: center; align-items: center; padding: 60px; background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3); max-width: 700px; margin: 50px auto;">
            <form id="contactForm" action="submit_contact.php" method="POST" style="width: 100%; padding: 40px; background: rgba(255, 255, 255, 0.15); border-radius: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); backdrop-filter: blur(15px);">
                <h2 style="text-align: center; color: #ffffff; font-size: 26px; margin-bottom: 20px; font-family: Arial, sans-serif; letter-spacing: 1.2px; text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);">Contact Us</h2>
                
                <label for="name" style="display: block; font-weight: bold; color: #e0e0e0; margin-top: 15px;">Name</label>
                <input type="text" id="name" name="name" required style="width: 100%; padding: 15px; border: none; border-radius: 12px; margin-top: 5px; box-sizing: border-box; background: rgba(255, 255, 255, 0.25); color: #333; font-size: 16px; outline: none; backdrop-filter: blur(5px); transition: all 0.3s ease;">

                <label for="email" style="display: block; font-weight: bold; color: #e0e0e0; margin-top: 15px;">Email</label>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 15px; border: none; border-radius: 12px; margin-top: 5px; box-sizing: border-box; background: rgba(255, 255, 255, 0.25); color: #333; font-size: 16px; outline: none; backdrop-filter: blur(5px); transition: all 0.3s ease;">

                <label for="message" style="display: block; font-weight: bold; color: #e0e0e0; margin-top: 15px;">Message</label>
                <textarea id="message" name="message" rows="4" required style="width: 100%; padding: 15px; border: none; border-radius: 12px; margin-top: 5px; box-sizing: border-box; background: rgba(255, 255, 255, 0.25); color: #333; font-size: 16px; outline: none; backdrop-filter: blur(5px); transition: all 0.3s ease;"></textarea>

                <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #ff7e5f, #feb47b); color: #ffffff; border: none; border-radius: 12px; margin-top: 20px; cursor: pointer; font-size: 18px; font-weight: bold; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    Send Message
                </button>
            </form>
        </section>

        <!-- Popup alert -->
        <div id="popupAlert" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: #4CAF50; color: white; padding: 15px 30px; border-radius: 8px; font-size: 18px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);">
            Message sent successfully!
        </div>
    </main>
    <?php include 'footer.php'; ?>

    <script>
        document.getElementById("contactForm").onsubmit = function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Simulate form submission and show the popup
            fetch('submit_contact.php', {
                method: 'POST',
                body: new FormData(document.getElementById("contactForm"))
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById("popupAlert").style.display = "block";
                    setTimeout(() => {
                        document.getElementById("popupAlert").style.display = "none";
                    }, 3000); // Hide after 3 seconds
                    document.getElementById("contactForm").reset(); // Reset form fields
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };
    </script>
</body>
</html>
