const fs = require('fs');
const file = 'd:\\App\\Xampp\\htdocs\\ukk-4\\public\\tutorial-builder.html';
let content = fs.readFileSync(file, 'utf8');

// New getTutorialJS function using double-quoted strings + concatenation
const newFn = `function getTutorialJS() {
    return "hljs.highlightAll();" +
    "document.addEventListener('DOMContentLoaded',function(){" +
    "var headings=document.querySelectorAll('h3');" +
    "var menu=document.getElementById('toc-menu');" +
    "var index=1;" +
    "headings.forEach(function(h3){" +
    "if(h3.innerText.indexOf('Modul')!==-1){" +
    "var id='modul-'+index;h3.id=id;" +
    "var textParts=h3.innerText.split(':');" +
    "var numStr=textParts[0].replace('Modul ','').trim();" +
    "var title=textParts[1]?textParts[1].trim():h3.innerText;" +
    "var li=document.createElement('li');" +
    "li.innerHTML='<a href=\\\\x22#'+id+'\\\\x22><span class=\\\\x22modul-num\\\\x22>'+numStr+'</span><span class=\\\\x22modul-title\\\\x22>'+title+'</span></a>';" +
    "menu.appendChild(li);" +
    "h3.classList.add('modul-heading');" +
    "h3.innerHTML='<span class=\\\\x22modul-badge\\\\x22>'+numStr+'</span><span class=\\\\x22modul-heading-title\\\\x22>'+title+'</span>';" +
    "index++;h3.style.scrollMarginTop='40px'" +
    "}});" +
    "document.querySelectorAll('.container ol').forEach(function(ol){" +
    "if(!ol.closest('blockquote')){ol.classList.add('step-list')}" +
    "});" +
    "var filterInput=document.getElementById('sidebar-filter');" +
    "if(filterInput){filterInput.addEventListener('input',function(e){" +
    "var query=e.target.value.toLowerCase();" +
    "document.querySelectorAll('.sidebar-menu li').forEach(function(li){" +
    "li.style.display=li.textContent.toLowerCase().indexOf(query)!==-1?'':'none'" +
    "})})};" +
    "var sections=Array.from(headings).filter(function(h){return h.id&&h.id.indexOf('modul-')===0});" +
    "var navLinks=document.querySelectorAll('.sidebar-menu a');" +
    "var progressFill=document.getElementById('progress-fill');" +
    "var progressLabel=document.getElementById('progress-label');" +
    "window.addEventListener('scroll',function(){" +
    "var currentId='';var currentIndex=0;" +
    "sections.forEach(function(sec,i){if(window.scrollY>=sec.offsetTop-120){currentId=sec.getAttribute('id');currentIndex=i+1}});" +
    "navLinks.forEach(function(a){a.classList.remove('active');" +
    "if(currentId&&a.getAttribute('href')==='#'+currentId){a.classList.add('active');a.scrollIntoView({block:'nearest',behavior:'smooth'})}" +
    "});" +
    "if(sections.length>0&&progressFill&&progressLabel){" +
    "var pct=Math.round(currentIndex/sections.length*100);" +
    "progressFill.style.width=pct+'%';progressLabel.textContent=currentIndex+'/'+sections.length" +
    "}})});";
}`;

// Find and replace the getTutorialJS function
const startMarker = 'function getTutorialJS() {';
const startIdx = content.indexOf(startMarker);
if (startIdx === -1) {
    console.log('ERROR: could not find getTutorialJS function');
    process.exit(1);
}

// Find the closing brace of the function (next `\n}` after start)
let braceCount = 0;
let endIdx = -1;
for (let i = startIdx; i < content.length; i++) {
    if (content[i] === '{') braceCount++;
    if (content[i] === '}') {
        braceCount--;
        if (braceCount === 0) {
            endIdx = i + 1;
            break;
        }
    }
}

if (endIdx === -1) {
    console.log('ERROR: could not find end of getTutorialJS function');
    process.exit(1);
}

const oldFn = content.substring(startIdx, endIdx);
console.log('Found function at position', startIdx, 'to', endIdx);
console.log('Old function length:', oldFn.length);
console.log('First 80 chars:', oldFn.substring(0, 80));

content = content.substring(0, startIdx) + newFn + content.substring(endIdx);
fs.writeFileSync(file, content, 'utf8');
console.log('File patched successfully!');
