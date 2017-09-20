dati1 = dlmread('../annotation/1/vid1_ogg/arousal.csv',';',1,4);
dati2 = dlmread('../annotation/2/vid1_ogg/arousal.csv',';',1,4);
dati3 = dlmread('../annotation/3/vid1_ogg/arousal.csv',';',1,4);
dati4 = dlmread('../annotation/6/vid1_ogg/arousal.csv',';',1,4);
dati5 = dlmread('../annotation/8/vid1_ogg/arousal.csv',';',1,4);
maxRow = max([size(dati1, 1) size(dati2, 1) size(dati3, 1) size(dati4, 1) size(dati5, 1)]);
dati1 = aggiustaDati(dati1, maxRow);
dati2 = aggiustaDati(dati2, maxRow);
dati3 = aggiustaDati(dati3, maxRow);
dati4 = aggiustaDati(dati4, maxRow);
dati5 = aggiustaDati(dati5, maxRow);

samplesMatrix = [dati1 dati2 dati3 dati4 dati5];
[row, K] = size(samplesMatrix); % K -> # Annotators

MLE = MaximumLikelihoodEstimator(samplesMatrix);

% To measure the agreement among the avaluators, the standard SD deviaton can
% be caluclated.
WV = WeightedVoting(samplesMatrix);
% Speech files with high SD value show low inter-evaluator agreement
% whereas low SD values show high inter-evaluator agreement.

EWE = EvaluatorWeightedEstimator(samplesMatrix, transpose(MLE));




subplot(4,1,1)
plot(samplesMatrix),
axis([1 row -1 1])
title('dati')

subplot(4,1,2)
plot(MLE),
axis([1 row -1 1])
title('Maximum Likelihood Estimator')

subplot(4,1,3)
plot(WV),
axis([1 row -1 1])
title('Mean Standard Deviation')

subplot(4,1,4)
plot(EWE)
axis([1 row -1 1])
title('Evaluator Weighted Esitmator')


function [dati]=aggiustaDati(dati, max)
    for i=size(dati, 1):max-1
       dati = [dati; 0]; 
    end
end
