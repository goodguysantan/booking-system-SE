// Duration button toggle
        const durationButtons = document.querySelectorAll('#duration-group .btn-option');
        durationButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                durationButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Court button toggle
        const courtButtons = document.querySelectorAll('#court-group .btn-option');
        courtButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                courtButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add Booking functionality
        document.querySelector('.btn-primary').addEventListener('click', function() {
            // Get form values
            const facility = document.querySelectorAll('select')[0].value;
            const date = document.querySelector('input[type="date"]').value;
            const time = document.querySelectorAll('select')[1].value;
            const durationBtn = document.querySelector('#duration-group .btn-option.active');
            const courtBtn = document.querySelector('#court-group .btn-option.active');
            
            const duration = durationBtn.textContent.trim();
            const court = courtBtn.textContent.trim();
            
            // Validate date
            if (!date) {
                alert('Please select a date');
                return;
            }
            
            // Format date from YYYY-MM-DD to DD/MM/YYYY
            const dateObj = new Date(date);
            const formattedDate = `${String(dateObj.getDate()).padStart(2, '0')}/${String(dateObj.getMonth() + 1).padStart(2, '0')}/${dateObj.getFullYear()}`;
            
            // Generate ID
            const facilityPrefix = facility.charAt(0).toUpperCase();
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            const bookingId = facilityPrefix + randomNum;
            
            // Create new row
            const tbody = document.querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="checkbox"></td>
                <td>${facility}</td>
                <td>${formattedDate}</td>
                <td>${time}</td>
                <td>${duration} Hour</td>
                <td>${court}</td>
                <td>${bookingId}</td>
            `;
            
            // Add row to table
            tbody.appendChild(newRow);
            
            // Show success message (optional)
            alert('Booking added successfully!');
        });
        // Select all checkbox functionality
        document.querySelector('thead input[type="checkbox"]').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });