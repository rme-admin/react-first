import React, { useState } from 'react';
import '../styles/GuestForm.css';

function GuestForm() {
  const [formData, setFormData] = useState({
    firstName: '',
    lastName: '',
    contactNumber: '',
    email: '',
    participationType: 'MSc Student',
    department: 'Physics',
    courseYear: 'Year 1',
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await fetch('http://localhost/tres-backend/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData),
      });
      alert('Registration successful!');
    } catch (err) {
      alert('Error submitting form.');
    }
  };

  return (
    <div className="guest-form">
      <header>
        <img src="/logo.png" alt="Nano to Infinity Club Logo" />
        <h1>Treasure Hunt</h1>
        <p>Random description of the event...</p>
      </header>
      <form onSubmit={handleSubmit}>
        <input type="text" name="firstName" placeholder="First Name" value={formData.firstName} onChange={handleChange} required />
        <input type="text" name="lastName" placeholder="Last Name" value={formData.lastName} onChange={handleChange} required />
        <input type="tel" name="contactNumber" placeholder="Contact Number" value={formData.contactNumber} onChange={handleChange} pattern="\d{10}" required />
        <input type="email" name="email" placeholder="Institutional Email ID" value={formData.email} onChange={handleChange} required />
        <select name="participationType" value={formData.participationType} onChange={handleChange}>
          <option value="MSc Student">MSc Student</option>
          <option value="PhD Scholar">PhD Scholar</option>
          <option value="Faculty">Faculty</option>
        </select>
        <select name="department" value={formData.department} onChange={handleChange}>
          <option value="Physics">Physics</option>
          <option value="Mathematics">Mathematics</option>
          <option value="Chemistry">Chemistry</option>
          <option value="Biotech">Biotech</option>
          <option value="Geology">Geology</option>
        </select>
        {formData.participationType === 'MSc Student' && (
          <select name="courseYear" value={formData.courseYear} onChange={handleChange}>
            <option value="Year 1">Year 1</option>
            <option value="Year 2">Year 2</option>
          </select>
        )}
        <button type="submit">Submit</button>
      </form>
    </div>
  );
}

export default GuestForm;
