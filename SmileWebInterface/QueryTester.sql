SELECT cat.category_id AS catCategoryID, category_name,quiz.chapter_id, chap.chapter_id, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
FROM quiz
INNER JOIN (
    SELECT cat.category_id AS catCategoryID, category_name, chapter_id, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
    FROM category as cat
    LEFT JOIN chapter AS chap ON cat.category_id = chap.category_id
) ON chap.chapter_id = quiz.chapter_id



    SELECT cat.category_id AS catCategoryID, category_name, chapter_id, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
    FROM chapter as chap
    LEFT JOIN category AS cat ON cat.category_id = chap.category_id


SELECT quiz.chapter_id AS quizChapterID, chap.chapChapterID, chap.catCategoryID, chap.category_name 
FROM quiz
INNER JOIN(
    SELECT *
    FROM(
    SELECT cat.category_id AS catCategoryID, category_name, chap.chapter_id AS chapChapterID, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
    FROM chapter as chap
    LEFT JOIN category AS cat ON cat.category_id = chap.category_id
    ) AS catchap
) catchap ON catchap.chapChapterID = quiz.chapter_id



SELECT catchap.catCategoryID AS categoryID, catchap.chapChapterID AS chapterID, category_name, chapter_title, chapter_number
FROM content
INNER JOIN(
SELECT *
    FROM(
    SELECT cat.category_id AS catCategoryID, category_name, chap.chapter_id AS chapChapterID, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
    FROM chapter as chap
    LEFT JOIN category AS cat ON cat.category_id = chap.category_id
    ) AS catchap
) catchap ON catchap.chapChapterID = content.chapter_id


SELECT catchap.catCategoryID AS categoryID, catchap.chapChapterID AS chapterID, category_name, chapter_title, chapter_number
                  FROM content
                  INNER JOIN(
                  SELECT *
                      FROM(
                      SELECT cat.category_id AS catCategoryID, category_name, chap.chapter_id AS chapChapterID, chap.category_id AS chapCategoryID, chapter_title, chapter_number 
                      FROM chapter as chap
                      LEFT JOIN category AS cat ON cat.category_id = chap.category_id
                      ) AS catchap
                  ) catchap ON catchap.chapChapterID = content.chapter_id



SELECT category.category_id AS categoryID, contchap.chapChapterID AS chapterID, category_name, chapter_title, chapter_number
                  FROM category
                  LEFT JOIN(
                  SELECT *
                      FROM(
                      SELECT category_id, cont.chapter_id AS contChapterID, chap.chapter_id AS chapChapterID, chapter_title, chapter_number 
                      FROM chapter as chap
                      INNER JOIN content AS cont ON cont.chapter_id = chap.chapter_id
                      ) AS contchap
                  ) contchap ON contchap.category_id = category.category_id



SELECT chap.chapter_id, chapter_image_url AS chapterImageURL, reading_image_url AS readingImageURL 
FROM chapter AS chap
INNER JOIN content AS cont ON cont.chapter_id = chap.chapter_id 
WHERE category_id='1'




SELECT category.category_id AS categoryID, category_name, contchap.number_of_chapters AS number_of_chapters, category_image_url AS categoryImageURL
                  FROM category
                  LEFT JOIN(
                  SELECT category_id, COUNT(category_id) AS number_of_chapters
                      FROM(
                      SELECT category_id, cont.chapter_id AS contChapterID, chap.chapter_id AS chapChapterID 
                      FROM chapter as chap
                      INNER JOIN content AS cont ON cont.chapter_id = chap.chapter_id
                      ) AS contchap
                      GROUP BY category_id
                  ) contchap ON contchap.category_id = category.category_id