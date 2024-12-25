import React, { useEffect, useState } from 'react';
import './AdminDashboard.css';

function AdminDashboard() {
  const [registrations, setRegistrations] = useState([]);

  useEffect(() => {
    fetch('http://localhost/tres-backend/get_registrations.php')
      .then((response) => response.json())
      .then((data) => {
        setRegistrations(data);
      })
      .catch((error) => {
        console.error('Error fetching registrations:', error);
      });
  }, []);

  const handleDownload = () => {
    window.location.href =
      'http://localhost/tres-backend/get_registrations.php?action=download';
  };

  return (
    <div className="admin-dashboard">
      <header>
        <h1>Admin Dashboard</h1>
        <button onClick={handleDownload} className="download-button">
          Download Excel
        </button>
      </header>
      <table className="registration-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Participation Type</th>
            <th>Department</th>
            <th>Course Year</th>
          </tr>
        </thead>
        <tbody>
          {registrations.map((registration) => (
            <tr key={registration.id}>
              <td>{registration.id}</td>
              <td>{registration.first_name}</td>
              <td>{registration.last_name}</td>
              <td>{registration.contact_number}</td>
              <td>{registration.email}</td>
              <td>{registration.participation_type}</td>
              <td>{registration.department}</td>
              <td>{registration.course_year || 'N/A'}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default AdminDashboard;
