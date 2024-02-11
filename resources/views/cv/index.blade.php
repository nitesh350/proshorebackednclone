<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillshore | CV</title>
    <link rel="stylesheet" href="{{ public_path('css/cv.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <section class="page">
        <header>
            <div class="bio-data">
                <img src="{{ public_path($user->profile->avatar_path) }}" alt="avatar" class="avatar">


                <div class="introduction">
                    <h1>{{ $user->firstName }} <br> {{ $user->lastName }}</h1>
                    <p>Frontend developer</p>
                </div>
            </div>
            <div class="contact">
                <ul>
                    <li>
                        <span>
                            <img src="{{ public_path('images/icons/Mail.png') }}" alt="mail-icon" class="icon">
                        </span>
                        {{ $user->email }}
                    </li>
                </ul>
            </div>
        </header>
        <main>
            <section id="career-container">
                <div class="career-card">
                    <h2 class="title">career</h2>
                    <p class="description">
                        {{ $user->profile->career }}
                    </p>
                </div>
                <div class="b-border"></div>
                <div class="career-card">
                    <h2 class="title">Education</h2>
                    <ul class="description">
                        <li class="h-gap">
                            {{ $user->profile->education }}
                        </li>
                    </ul>
                </div>
            </section>
            <div class="v-border"></div>
            <aside id="experience">
                <h1 class="title">Experience</h1>
                <div class="experience-card">
                    <p class="description">{{ $user->profile->experience }}</p>
                </div>
                <div class="b-border"></div>
                <div id="skills">
                    <h1 class="title">Skills</h1>
                    <div class="skills-meter">
                        @foreach ($results as $result)
                            <div class="skills-box">
                                @php
                                    $skill = explode(' ', $result->quiz->title);
                                @endphp
                                <div class="skill-title">{{ $skill[0] }}</div>
                                <div class="skill-bar">
                                    <div class="progress" style="width: {{ $result->quiz->pass_percentage . '%;' }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </main>
    </section>
</body>

</html>
