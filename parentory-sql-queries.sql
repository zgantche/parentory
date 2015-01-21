/* default wordpress query*/

SELECT 		SQL_CALC_FOUND_ROWS wp_posts.ID 
FROM 		wp_posts 
INNER JOIN 	wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id 
INNER JOIN 	wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
INNER JOIN 	wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id 
WHERE 		1=1 
		AND 
			(((wp_posts.post_title LIKE '%french%') OR (wp_posts.post_content LIKE '%french%'))) 
		AND 
			wp_posts.post_type IN ('post', 'page', 'attachment', 'school') 
		AND 
			(wp_posts.post_status = 'publish' OR wp_posts.post_author = 1 AND wp_posts.post_status = 'private') 
		OR 
			( wp_term_taxonomy.taxonomy LIKE 'languages' AND wp_terms.name LIKE '%obligatoryTerm%' OR wp_terms.name LIKE '%german%' )
		OR 
			wp_terms.name LIKE %french%) 
GROUP BY 	wp_posts.ID 
ORDER BY 	wp_posts.post_title LIKE '%french%' DESC, wp_posts.post_date DESC LIMIT 0, 10



/****** header-search query ******/

SELECT 		wp_posts.ID 
FROM 		wp_posts 
INNER JOIN 	wp_postmeta 
			ON wp_posts.ID = wp_postmeta.post_id 
WHERE 		wp_posts.post_type IN ('school') 
		AND wp_posts.post_status = 'publish' 
		AND (
				wp_posts.post_title LIKE '%word1%' OR 
				wp_posts.post_title LIKE '%word2%' OR 
				wp_postmeta.meta_value LIKE '%word1%' OR 
				wp_postmeta.meta_value LIKE '%word2%'
			)
UNION 
SELECT 		wp_term_relationships.object_id 
FROM 		wp_term_relationships 
INNER JOIN 	wp_term_taxonomy 
			ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
INNER JOIN 	wp_terms 
			ON wp_term_taxonomy.term_id = wp_terms.term_id 
WHERE 		wp_terms.name LIKE '%word1%' OR 
			wp_terms.name LIKE '%word2%'




/****** directory-page-search query (using Address & Province) ******/

/* only if both Address and Province are defined */
SELECT 		G.ID
FROM		(
			SELECT 		wp_posts.ID 
			FROM 		wp_posts 
			INNER JOIN 	wp_postmeta 
						ON wp_posts.ID = wp_postmeta.post_id 
			WHERE 		wp_posts.post_type IN ('school') 
					AND wp_posts.post_status = 'publish' 
					/* only include if Province was selected */
					AND (
							wp_postmeta.meta_key = "school-province" AND
							wp_postmeta.meta_value = "dropdown_value"
						)
					/* only include if Address was input */
					OR (
							wp_postmeta.meta_value LIKE '%address_word1%' OR 
							wp_postmeta.meta_value LIKE '%address_word2%'
						)
/* only if both Address and Province are defined */
			) as G
GROUP BY	G.ID
HAVING 		Count(*) >= 2




/****** focused-search & advanced-search query ******/

/* 
1. Query for Address & Province */

SELECT 		G.ID
FROM 		(
			SELECT 		wp_posts.ID 
			FROM 		wp_posts 
			INNER JOIN 	wp_postmeta 
						ON wp_posts.ID = wp_postmeta.post_id 
			WHERE 		wp_posts.post_type IN ('school') 
					AND wp_posts.post_status = 'publish' 
					/* only include if Province was selected */
					AND (
							wp_postmeta.meta_key = "school-province" AND
							wp_postmeta.meta_value = "dropdown_value"
						)
					/* only include if Address was input */
					OR (
							wp_postmeta.meta_value LIKE '%address_word1%' OR 
							wp_postmeta.meta_value LIKE '%address_word2%'
						)
			) AS G
GROUP BY	G.ID
HAVING 		Count(*) = $total_num_criteria


/* 
2. Query for range fields */

SELECT		G.post_id
FROM		(
				SELECT wp_postmeta.post_id, wp_postmeta.meta_value
				FROM wp_postmeta
				WHERE wp_postmeta.meta_key
				IN ('school-annual-tuition-min',  'school-annual-tuition-max')
			) AS G
GROUP BY	G.post_id
HAVING		(13000 BETWEEN MIN(G.meta_value) AND MAX(G.meta_value)) 
			OR (18000 BETWEEN MIN(G.meta_value) AND MAX(G.meta_value))


				IN ('school-class-size-min',  'school-class-size-max')
				IN ('school-grades-min',  'school-grades-max')

UNION 


/* 
3. Query for Taxonomy Terms */

SELECT 		G.object_id
FROM		(
			SELECT 		wp_term_relationships.object_id
			FROM 		wp_term_relationships 
			INNER JOIN 	wp_term_taxonomy 
						ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
			INNER JOIN 	wp_terms 
						ON wp_term_taxonomy.term_id = wp_terms.term_id 
			WHERE 		wp_terms.slug IN ('Archery', 'Badminton', 'Baseball', ...)
			) as G
GROUP BY	G.object_id
HAVING 		Count(*) = [termsCount]