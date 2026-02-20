-- Phase 1 schema for Exam Validator
-- Designed for Laravel + MySQL

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE blueprints (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    total_marks INT NOT NULL,
    theory_percentage DECIMAL(5,2) NOT NULL,
    problem_solving_percentage DECIMAL(5,2) NOT NULL,
    tolerance_percentage DECIMAL(5,2) NOT NULL DEFAULT 5.00,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_blueprints_course FOREIGN KEY (course_id) REFERENCES courses(id),
    CONSTRAINT fk_blueprints_creator FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE blueprint_rules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blueprint_id BIGINT UNSIGNED NOT NULL,
    rule_type ENUM('type', 'topic', 'difficulty') NOT NULL,
    rule_key VARCHAR(100) NOT NULL,
    expected_percentage DECIMAL(5,2) NOT NULL,
    min_percentage DECIMAL(5,2) NOT NULL,
    max_percentage DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_rules_blueprint FOREIGN KEY (blueprint_id) REFERENCES blueprints(id) ON DELETE CASCADE,
    UNIQUE KEY uq_blueprint_rule (blueprint_id, rule_type, rule_key)
);

CREATE TABLE exams (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    blueprint_id BIGINT UNSIGNED NOT NULL,
    lecturer_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    status ENUM('draft', 'submitted', 'approved', 'rejected') NOT NULL DEFAULT 'draft',
    validation_score DECIMAL(5,2) NULL,
    submitted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_exams_course FOREIGN KEY (course_id) REFERENCES courses(id),
    CONSTRAINT fk_exams_blueprint FOREIGN KEY (blueprint_id) REFERENCES blueprints(id),
    CONSTRAINT fk_exams_lecturer FOREIGN KEY (lecturer_id) REFERENCES users(id)
);

CREATE TABLE questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    exam_id BIGINT UNSIGNED NOT NULL,
    question_text TEXT NOT NULL,
    question_type ENUM('theory', 'problem_solving') NOT NULL,
    topic VARCHAR(100) NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL,
    marks DECIMAL(6,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_questions_exam FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

CREATE TABLE validation_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    exam_id BIGINT UNSIGNED NOT NULL,
    validated_by BIGINT UNSIGNED NULL,
    result ENUM('pass', 'fail') NOT NULL,
    summary JSON NOT NULL,
    created_at TIMESTAMP NULL,
    CONSTRAINT fk_validation_exam FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    CONSTRAINT fk_validation_user FOREIGN KEY (validated_by) REFERENCES users(id)
);
