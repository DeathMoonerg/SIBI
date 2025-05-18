-- Create temporary table
CREATE TABLE progresses_temp (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NULL,
    date DATE NOT NULL,
    activity_description TEXT NULL,
    achievement TEXT NULL,
    behavior TEXT NULL,
    participation TEXT NULL,
    attention TEXT NULL,
    notes TEXT NULL,
    teacher_feedback TEXT NULL,
    parent_feedback TEXT NULL,
    status ENUM('Draft', 'Published', 'Reviewed') DEFAULT 'Draft',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX progresses_student_id_date_index (student_id, date),
    CONSTRAINT progresses_temp_student_id_foreign FOREIGN KEY (student_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT progresses_temp_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES users (id) ON DELETE SET NULL
);

-- Copy data from old table to new table
INSERT INTO progresses_temp (
    id, student_id, teacher_id, date, activity_description, 
    achievement, behavior, participation, attention, 
    notes, teacher_feedback, parent_feedback, status, 
    created_at, updated_at
)
SELECT 
    id, student_id, teacher_id, date, activity_description, 
    achievement, behavior, participation, attention, 
    notes, teacher_feedback, parent_feedback, status, 
    created_at, updated_at
FROM progresses;

-- Drop old table
DROP TABLE progresses;

-- Rename new table to old table name
RENAME TABLE progresses_temp TO progresses; 
 
 
 
 
 
 