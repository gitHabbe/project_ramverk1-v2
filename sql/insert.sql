INSERT INTO User ("username", "password", "quote") VALUES 
    ('mogger0', 'oSagbsQcX', 'Cross-group bi-directional migration'),
    ('vaslet1', 'D1Eoye3P', 'Team-oriented optimizing Graphic Interface'),
    ('lpele2', 'dGJBvc', 'Assimilated coherent neural-net'),
    ('kvigietti3', 'Twt0RwW', 'Visionary intangible knowledge user'),
    ('sletty4', 'Qea5Stgyn1', 'Organic directional adapter'),
    ('spendrid5', 'HOzriiy', 'Advanced mission-critical moratorium'),
    ('esizzey6', '3Xbolji6', 'Open-architected zero defect definition'),
    ('cdavall7', 'Bz5ibk', 'Proactive web-enabled local area network'),
    ('mfransewich8', '8RBVwBt', 'Self-enabling zero defect application'),
    ('fchestnut9', 'FOkIRj', 'Optimized full-range archive'),
    ('sgathera', '3UU6pGLhN', 'Robust foreground structure'),
    ('dhyderb', 'qqI9IFf', 'Devolved client-driven Graphical User Interface'),
    ('abenc', 'grZFUmf3yE6p', 'Digitized optimizing orchestration'),
    ('morrocksd', 'wNdsAB5Uy', 'Intuitive solution-oriented functionalities'),
    ('ldellare', 'F9tueltR', 'Business-focused bandwidth-monitored workforce'),
    ('nguilloneauf', '0bQIdW0AP', 'Ergonomic analyzing pricing structure'),
    ('nlipsong', '1zg4LE3b', 'Up-sized system-worthy forecast'),
    ('qtomensonh', '92aWAi', 'Re-contextualized static collaboration'),
    ('gschuberti', 'utS3kZb3p6', 'Synergized actuating emulation'),
    ('jbenyonj', 'RYSyhyPae', 'Team-oriented 3rd generation array'),
    ('testing', '$2y$10$Knz', 'Test quote')
;
INSERT INTO Tag ("name") VALUES
    ("hero"),
    ("villain"),
    ("theory"),
    ("theboys"),
    ("seven"),
    ("cast")
;

INSERT INTO Thread ("user_id", "topic", "content") VALUES
    (8, 'Vad heter homelander?', 'Vilket namn var det homelander hade?'),
    (9, 'Butcher.', 'Hur hittade Butcher Hughie?'),
    (2, 'Seven', 'Har Homelander alltid varit medlem i The Seven?'),
    (7, 'The boys', 'Hur länge har The Boys slagits mot The Seven?'),
    (8, 'Doktorn', 'Varför experimenterade doktorn på barn?'),
    (4, 'Smart', 'Det var smart av the boys att missleda Homelander the bomber, tycker ni inte?'),
    (10, 'Förnamn', 'Vad heter Butcher i förnamn?'),
    (9, 'konflikt', 'Varför är det en konflikt mellan Frenchie och MM?'),
    (5, 'Robin', 'Har vi sett den sista illusionen av Robin nu?'),
    (9, 'Huvuden', 'Vem tror ni spränger alla huvuden?'),
    (4, 'Hur?', 'Hur kan huden på Translucant inte skadas?'),
    (8, 'Brådska', 'Varför kunde inte A-Train stanna? Vad tror ni han hade i väskan?'),
    (3, 'Planet', 'Hur kommer det sig att Homelander inte ens försökte lyfta planet?'),
    (7, 'Hur många har Seven dödat', 'Titeln. Vad tror ni?'),
    (2, 'Ny hjälte', 'Vad tror ni att den nya "hjälten" kommer har för krafter?'),
    (2, 'Ny säsong', 'Längtar till nästa säsong. Tagga'),
    (10, 'A-Train', 'Vad geter A-Train'),
    (1, 'Vem', 'Vem startade the boys gruppen'),
    (4, 'Hur', 'Hur kan Vought kontrollera dom på det viset?'),
    (5, 'Becca', 'Varför försökte inte Becca kontakta Butcher?')
;

INSERT INTO Comment ("thread_id", "user_id", "name") VALUES
    (5, 9, 'Kanske blev rikligt belönt'),
    (9, 5, 'Förmodligen. Han har nog släppt det nu.'),
    (3, 3, 'Det tror jag inte. Det skapades nog före han var född.'),
    (2, 6, 'Väldigt bra fråga!'),
    (6, 3, 'Otroligt smart!'),
    (12, 7, 'Kanske ar drågad på Comp-V och hade det i väskan'),
    (1, 4, 'John tror jag dom nämnde i något avsnitt. Kanske för John Doe'),
    (2, 6, 'Han spionerade nog på allt relaterat till Vought'),
    (9, 3, 'Jag tror också det.'),
    (4, 9, 'Dom har nog inte uppgett det än'),
    (10, 7, 'Det får man veta i season 2'),
    (6, 4, 'Detta är nog inte nytt till dom'),
    (16, 10, 'Lääääängtar'),
    (14, 7, 'Säkert tusentals totalt'),
    (17, 10, 'Tror inte dom nämnt det i serien, men det finns information på nätet.'),
    (9, 9, 'Håller med'),
    (7, 3, 'William!'),
    (12, 8, 'Jaa, såklart!'),
    (5, 2, 'Han kanske var tvingad!'),
    (2, 2, 'Förmodligen via nyheterna bara.')
;

INSERT INTO Tag_2_Thread ("thread_id", "tag_id") VALUES
    (1, 2),
    (1, 5),
    (2, 2),
    (1, 4),
    (4, 1),
    (2, 5),
    (5, 2),
    (6, 2),
    (6, 1),
    (1, 6),
    (14, 3),
    (14, 1),
    (11, 3),
    (18, 6),
    (5, 6)
;

-- SELECT * FROM User;
-- SELECT * FROM Thread;

DROP TRIGGER IF EXISTS update_user_and_thread_points;
DROP TRIGGER IF EXISTS update_user_and_comment_points;