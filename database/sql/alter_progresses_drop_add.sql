-- Drop existing columns
ALTER TABLE progresses DROP COLUMN behavior;
ALTER TABLE progresses DROP COLUMN participation;
ALTER TABLE progresses DROP COLUMN attention;

-- Add new text columns
ALTER TABLE progresses ADD COLUMN behavior TEXT NULL;
ALTER TABLE progresses ADD COLUMN participation TEXT NULL;
ALTER TABLE progresses ADD COLUMN attention TEXT NULL; 
 
 
 
 
 
 