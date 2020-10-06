export interface Category {
    category_id: number;
    category_name: string;
    category_image_url: string;
  };

export interface LoginCredential {
  email: string;
  password: string;
};

export interface PostData {
  firstName: string;
  lastName: string;
  email: string;
  password: string;
  confirmPassword: string;
  start_date: string;
};

export interface UpdateStats {
  total_count_message_A: number,
  Q1_count_message_A: number,
  Q2_count_message_A: number,
  Q4_count_message_A: number,
  Q5_count_message_A: number,
  Q6_count_message_A: number,
  Q7_count_message_C: number,
  Q8_count_message_D: number,
};

export interface ChangeInfo {
  userID: string;
  firstName: string;
  lastName: string;
  email: string;
};

export interface Chapter {
  chapter_id: number;
  category_id: number;
  chapter_title: string;
  chapter_number: number;
  chapter_image_url: string;
};

export interface Content {
  chapter_id: number;
  reading: string;
  reading_image_url: string;
  video_url: string;
  video_description: string;
};

export interface Quiz {
  chapter_id: number;
  question1: string;
  answer_1: string;
  falseAnswer1_1: string;
  falseAnswer1_2: string;
  falseAnswer1_3: string;
  question2: string;
  answer_2: string;
  falseAnswer2_1: string;
  falseAnswer2_2: string;
  falseAnswer2_3: string;
  question3: string;
  answer_3: string;
  falseAnswer3_1: string;
  falseAnswer3_2: string;
  falseAnswer3_3: string;
  question4: string;
  answer_4: string;
  falseAnswer4_1: string;
  falseAnswer4_2: string;
  falseAnswer4_3: string;
  question5: string;
  answer_5: string;
  falseAnswer5_1: string;
  falseAnswer5_2: string;
  falseAnswer5_3: string;
};

export interface ChangePassword {
  userID: string;
  password: string;
  new_password: string;
};

export interface answerSubmission {
  1: string;
  2: string;
  3: string;
  4: string;
};
