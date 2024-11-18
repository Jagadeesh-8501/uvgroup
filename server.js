const express = require('express');
const fs = require('fs');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

app.use(bodyParser.json());

// Serve the HTML file
app.use(express.static('public')); // Assuming your HTML file is in the 'public' folder

// Serve the jobs.json file when requested
app.get('/jobs.json', (req, res) => {
    fs.readFile(path.join(__dirname, 'jobs.json'), 'utf8', (err, data) => {
        if (err) {
            return res.status(500).json({ error: 'Unable to read jobs data' });
        }
        res.json(JSON.parse(data));
    });
});

// Endpoint to handle the deletion of a job
app.post('/deleteJob', (req, res) => {
    const { index } = req.body;
    
    // Read jobs.json
    fs.readFile('job.json', (err, data) => {
        if (err) {
            console.error("Error reading the file", err);
            return res.status(500).send('Error reading jobs data');
        }

        let jobsData = JSON.parse(data);
        
        // Remove the job at the specified index
        jobsData.jobs.splice(index, 1);

        // Write the updated data back to jobs.json
        fs.writeFile('jobs.json', JSON.stringify(jobsData, null, 2), (err) => {
            if (err) {
                console.error("Error writing to file", err);
                return res.status(500).send('Error saving updated jobs');
            }
            
            // Send a success response
            res.status(200).send('Job deleted successfully');
        });
    });
});

// Start the server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
