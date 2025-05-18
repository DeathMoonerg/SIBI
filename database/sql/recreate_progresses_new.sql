-- Create temporary table with new structure
CREATE TABLE progresses_temp (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    start_time VARCHAR(255) NOT NULL,
    end_time VARCHAR(255) NOT NULL,
    material_covered TEXT NOT NULL,
    achievements TEXT NOT NULL,
    challenges TEXT NOT NULL,
    score INT NOT NULL,
    overall_score INT NULL,
    attitude VARCHAR(255) NOT NULL,
    notes TEXT NULL,
    recommendations TEXT NOT NULL,
    next_meeting_plan TEXT NOT NULL,
    parent_comment TEXT NULL,
    parent_comment_at TIMESTAMP NULL,
    teacher_reply TEXT NULL,
    teacher_reply_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_date (date),
    INDEX idx_student (student_id),
    INDEX idx_teacher (teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copy existing data with new structure
INSERT INTO progresses_temp (
    id, student_id, teacher_id, date,
    material_covered, achievements, notes,
    created_at, updated_at
)
SELECT 
    id, student_id, teacher_id, date,
    activity_description, achievement, notes,
    created_at, updated_at
FROM progresses;

-- Update default values for required fields
UPDATE progresses_temp SET
    start_time = '08:00',
    end_time = '09:00',
    challenges = 'No challenges recorded',
    score = 0,
    attitude = 'Good',
    recommendations = 'No recommendations yet',
    next_meeting_plan = 'To be determined'
WHERE id > 0;

-- Drop old table
DROP TABLE progresses;

-- Rename new table
RENAME TABLE progresses_temp TO progresses; 
 
 
 
 
 
 