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
		AND
			(wp_posts.post_title LIKE '%word1%' OR wp_posts.post_title LIKE '%word2%') OR 
			(wp_postmeta.meta_value LIKE '%word1%' OR wp_postmeta.meta_value LIKE '%word2%')
UNION 
SELECT 		wp_term_relationships.object_id 
FROM 		wp_term_relationships 
INNER JOIN 	wp_term_taxonomy 
			ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id 
INNER JOIN 	wp_terms 
			ON wp_term_taxonomy.term_id = wp_terms.term_id 
WHERE 		wp_terms.name LIKE '%word1%' OR 
			wp_terms.name LIKE '%word2%'


SELECT 		wp_posts.ID 
FROM 		wp_posts 
INNER JOIN 	wp_postmeta 
			ON wp_posts.ID = wp_postmeta.post_id 
WHERE 		wp_posts.post_type IN ('school') 
		AND wp_posts.post_status = 'publish' 
		AND
			(wp_posts.post_title LIKE '%word1%' OR wp_posts.post_title LIKE '%word2%') OR 
			(wp_postmeta.meta_value LIKE '%word1%' OR wp_postmeta.meta_value LIKE '%word2%')
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


/****** advanced-search query ******/


/****** filtered-search query ******/